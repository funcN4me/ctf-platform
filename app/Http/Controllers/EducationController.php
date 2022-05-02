<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class EducationController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $categoryResources = [];

        foreach ($categories as $category) {
            $categoryResources[$category->name] = [];
            foreach ($category->resources as $resource) {
                if (!in_array($resource->id, $categoryResources[$category->name])) {
                    $categoryResources[$category->name][] = $resource->id;
                }
            }
        }

        foreach ($categoryResources as $category => $resources) {
            foreach ($resources as $key => $resource) {
                $categoryResources[$category][$key] = Resource::find($resource);
            }
        }

        return view('education', compact('categories', 'categoryResources'));


//        return view('education', compact('categories', 'categoryResources'));
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
