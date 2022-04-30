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

    public function edit(Request $request, Resource $resource)
    {
        dd($request->input());
    }
}
