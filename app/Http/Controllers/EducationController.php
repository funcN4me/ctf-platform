<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Resource;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        $categoryResources = [];
        foreach ($categories as $category) {
            foreach ($category->tasks as $task) {
                $categoryResources[$category->name] = $task->resources;
            }
        }
        $categoryResources = array_unique($categoryResources);

        return view('education', compact('categories', 'categoryResources'));
    }

    public function show(Resource $resource)
    {
        return view('article', compact('resource'));
    }

    public function showEdit(Resource $resource)
    {
        return view('article_edit', compact('resource'));
    }

    public function edit(Request $request, Resource $resource)
    {
        if (!$resource->update(['content' => $request->resource_content])) {
            return back()->with('error', 'Не удалось обновить ресурс');
        }
        return back()->with('success', 'Ресурс обновлён');

    }

    public function delete(Resource $resource)
    {
        foreach ($resource->tasks as $task) {
            $task->resources()->detach($task->id);
        }

        if ($resource->delete()) {
            return back();
        }

        return abort(500);

    }
}
