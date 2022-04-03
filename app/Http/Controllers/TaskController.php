<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckFlagRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Models\Attachment;
use App\Models\Category;
use App\Models\Task;
use Illuminate\Http\Request;
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
        if ($request->category === 'Other') {
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

                $fileModel->name = time().'_'.$attachment->getClientOriginalName();
                $fileModel->task_id = $task->id;
                $fileModel->file_path = '/storage/' . $filePath;
                $fileModel->save();
            }
        }

        return back()->with('success', 'Задание создано');
    }
}
