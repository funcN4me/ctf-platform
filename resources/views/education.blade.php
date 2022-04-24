@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-start">
            @foreach($categories as $category)
                @if($category->tasks->count() !== 0)
                    <span class="category_name">{{ $category->name }}</span>
                    @foreach($categoryResources[$category->name] as $resource)
                        <div class="container">
                            <a href="{{ route('resource.show', $resource->id) }}">
                                <div class="container card pt-2 mb-3 resource-card" style="height: 10vh;">
                                    <h3>{{$resource->title}}</h3>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @endif
            @endforeach
        </div>
    </div>
@endsection
