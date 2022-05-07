@extends('layouts.new_app')

@section('header', 'Список ресурсов')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                @foreach($categories as $category)
                    @if($category->tasks->count() !== 0)
                        <div class="col-lg-12">
                            <p class="category_name">Категория: {{ $category->name }}</p>
                            @foreach($categoryResources[$category->name] as $resource)
                                <a href="{{ route('resource.show', $resource->id) }}">
                                    <div class="container card pt-2 mb-3 resource-card" style="height: 10vh;">
                                        <h3>{{ $resource->title }}</h3>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>
@endsection
