@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-start">
            @foreach(\App\Models\Category::all() as $category)
                @if($category->tasks->count() !== 0)
                    <span class="category_name">{{ $category->name }}</span>
                @endif
                @foreach($tasks as $task)
                    @if($task->category->name == $category->name)
                        <div class="col-md-2 mb-4">
                        <div class="card">
                            <div class="card-header">{{ $task->sub_category }}</div>

                            <div class="card-body">
                                {{ $task->name }}
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
            @endforeach
        </div>
    </div>
@endsection
