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
        $resources = Resource::all();
        return view('create_task', compact('categories', 'resources'));
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
        if ($request->category == 'Other' && Category::where('name', $request->category)->exists()) {
            return back()->with('error', 'Данная категория уже существует');
        }

        if ($request->category == 'Other') {
            $category = new Category();
            $category->name = $request->new_category;
            $category->save();
        }
        else {
            $category = Category::firstWhere('name', $request->category);
        }

        if (empty($request->resources) && empty(array_filter($request->new_resources))) {
            return back()->with('error', 'Для задачи обязателен ресурс');
        }

        $task = new Task();
        $task->name = $request->name;
        $task->category_id = $category->id;
        $task->subcategory = $request->subcategory;
        $task->description = $request->description;
        $task->url = $request->url;

        if (Task::where('flag', '4hsl33p{' . $request->flag . '}')->exists()) {
            return back()->with('error', 'Данный флаг уже используется');
        }

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
        foreach ($request->new_resources as $newResourceTitle) {
            if (!$newResourceTitle) {
                continue;
            }
            $resource = new Resource([
                'category_id' => $category->id,
                'title' => $newResourceTitle
            ]);

            if (!$resource->save()) {
                abort(500);
            }

            $task->resources()->attach($resource->id);
        } //TODO: Разобраться с ресурсами для обучения

        if (!$request->resources) {
            return back()->with('success', 'Задание создано');
        }
        foreach ($request->resources as $resourceId) {
            if (!$task->hasResource($resourceId)) {
                $task->resources()->attach($resourceId);
            }
        }

        return back()->with('success', 'Задание создано');
    }

    public function delete(Task $task)
    {
        $default_categories = ['Web', 'Reverse', 'Stegano', 'Forensic', 'Networking'];

        foreach ($task->users as $user) {
            $task->users()->detach($user->id);
        }

        if (!in_array($task->category->name, $default_categories)) {
            $task->category()->delete();
        }

        foreach ($task->attachments as $attachment) {
            $attachment->delete();
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
        $resources = Resource::all();
        return view('admin.edit_task', compact('task', 'categories', 'resources'));
    }

    public function update(UpdateTaskRequest $request,Task $task)
    {
        if ($request->category == 'Other' && Category::where('name', $request->category)->exists()) {
            return back()->with('error', 'Данная категория уже существует');
        }

        if ($request->category == 'Other') {
            $category = new Category(['name' => $request->new_category]);
            $category->save();
        }
        else {
            $category = Category::firstWhere('name', $request->category);
        }

        if (empty($request->resources) && empty(array_filter($request->new_resources))) {
            return back()->with('error', 'Для задачи обязателен ресурс');
        }
        $task->name = $request->name;
        $oldCategory = $task->category;
        $task->category_id = $category->id;

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

        $task->resources()->detach();

        foreach ($request->new_resources as $newResourceTitle) {
            if (!$newResourceTitle) {
                continue;
            }
            $resource = new Resource([
                'category_id' => $category->id,
                'title' => $newResourceTitle
            ]);

            if (!$resource->save()) {
                abort(500);
            }

            $task->resources()->attach($resource->id);
        } //TODO: Разобраться с ресурсами для обучения

        if (!$request->resources) {
            return back()->with('success', 'Задание создано');
        }
        foreach ($request->resources as $resourceId) {
            if (!$task->hasResource($resourceId)) {
                $task->resources()->attach($resourceId);
            }
        }

        $task->subcategory = $request->subcategory;
        $task->description = $request->description;
        $task->url = $request->url;
        $task->flag = $request->flag;
        $task->update();

        if (!count($oldCategory->tasks)) {
            $oldCategory->delete();
        }

        return back()->with('success', 'Задание обновлено');
    }
}
