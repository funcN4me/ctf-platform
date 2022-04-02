<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Models\Attachment;
use App\Models\Category;
use App\Models\Task;

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

    public function store(StoreTaskRequest $request)
    {
        $task = new Task();
        $task->name = $request->name;

        if ($request->category == '-1' && $request->new_category) {
            $category = new Category();
            $category->name = $request->new_category;
            $category->save();

            $task->category_id = $category->id;
        }
        else {
            $task->category_id = $request->category;
        }

        $task->sub_category = $request->subcategory;
        $task->description = $request->description;
        $task->url = $request->link;
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
