@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-start">
            @foreach(\App\Models\Category::all() as $category)
                @if($category->tasks->count() !== 0)
                    <span class="category_name">{{ $category->name }}</span>
                @endif
            @endforeach
        </div>
    </div>
@endsection
