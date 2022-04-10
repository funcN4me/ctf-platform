<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckFlagRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Attachment;
use App\Models\Category;
use App\Models\Resource;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function show()
    {
        $tasks = Task::all();
        return view('tasks', compact('tasks'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('create_task', compact('categories'));
    }

    public function get($id)
    {
        $task = Task::find($id);
        $attachments = Attachment::where('task_id', $task->id)->get();

        return response()->json([
            'data' => $task,
            'attachments' => $attachments,
        ]);
    }

    public function download($name)
    {
        $attachment = Attachment::firstWhere('name', $name);
        $pathToFile = $attachment->file_path;
        return response()->download($pathToFile);
    }

    public function check(CheckFlagRequest $request)
    {
        $task = Task::find($request->task_id);
        if ($task->flag === $request->flag) {
            $user = Auth::user();
            $user->tasks()->attach([$task->id]);

            return response()->json(array('success' => true));
        }

        return response()->json(array('fail' => true));
    }

    public function store(StoreTaskRequest $request)
    {
        $task = new Task();
        $task->name = $request->name;

//        foreach ($request->resources as $resourceTitle) {
//            $resource = new Resource([
//                'title' => $resourceTitle
//            ]);
//
//            if (!$resource->save()) {
//                abort(500);
//            }
//
//            $task->resources()->attach($resource->id);
//        } TODO: Разобраться с ресурсами для обучения

        if ($request->category === 'Other') {
            if (Category::where('name', $request->category)->exists()) {
                return back()->with('error', 'Данная категория уже существует');
            }
            $category = new Category();
            $category->name = $request->new_category;
            $category->save();

            $task->category_id = $category->id;
        }
        else {
            $task->category_id = Category::firstWhere('name', $request->category)->id;
        }

        $task->sub_category = $request->subcategory;
        $task->description = $request->description;
        $task->url = $request->url;
        $task->flag = '4hsl33p{' . $request->flag . '}';
        $task->save();

        if ($request->hasFile('attachments')) {
            $attachments = $request->file('attachments');

            foreach ($attachments as $attachment) {
                $fileModel = new Attachment();
                $fileName = time().'_'.$attachment->getClientOriginalName();
                $filePath = $attachment->storeAs('uploads', $fileName, 'public');

                $fileModel->name = $attachment->getClientOriginalName();
                $fileModel->task_id = $task->id;
                $fileModel->file_path = '/storage/' . $filePath;
                $fileModel->save();
            }
        }

        return back()->with('success', 'Задание создано');
    }

    public function delete(Task $task)
    {
        foreach ($task->users as $user) {
            $task->users()->detach($user->id);
        }

        if ($task->delete()) {
            return back();
        }
        return abort(500);

    }

    public function deleteAttachment(Attachment $attachment)
    {
        if ($attachment->delete())
            return response()->json(array('response' => 'successful'));
        else
            return response()->json(array('response' => 'failed'));
    }

    public function edit(Task $task)
    {
        $categories = Category::all();
        return view('admin.edit_task', compact('task', 'categories'));
    }

    public function update(UpdateTaskRequest $request,Task $task)
    {
        $task->name = $request->name;

        if ($request->category === 'Other') {

            if (Category::where('name', $request->category)->exists()) {
                return back()->with('error', 'Данная категория уже существует');
            }

            $category = new Category([
                'name' => $request->new_category
            ]);
            $category->save();

            $task->category_id = $category->id;
        }
        else {
            $task->category_id = Category::firstWhere('name', $request->category)->id;
        }

        if ($request->hasFile('attachments')) {
            $attachments = $request->file('attachments');

            foreach ($attachments as $attachment) {
                $fileModel = new Attachment();
                $fileName = time().'_'.$attachment->getClientOriginalName();
                $filePath = $attachment->storeAs('uploads', $fileName, 'public');

                $fileModel->name = $attachment->getClientOriginalName();
                $fileModel->task_id = $task->id;
                $fileModel->file_path = '/storage/' . $filePath;
                $fileModel->save();
            }
        }

        $task->sub_category = $request->subcategory;
        $task->description = $request->description;
        $task->url = $request->url;
        $task->flag = $request->flag;
        $task->save();


        return back()->with('success', 'Задание создано');
    }
}
