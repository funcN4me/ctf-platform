@extends('layouts.new_app')

@section('header')
    {{ $resource->title }}
    @if(auth()->user()->isAdmin())
        <a href="{{ route('resource.showEdit', $resource->id) }}" style="font-size: 18px; color: #0a53be">(редактировать)</a>
    @endif
@endsection
@section('breadcrumbs')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('education.show') }}">Список ресурсов</a></li>
        <li class="breadcrumb-item active">{{ $resource->title }}</li>
    </ol>
@endsection

@section('content')
    <div class="container">
            {!! $resource->content !!}
    </div>
@endsection
