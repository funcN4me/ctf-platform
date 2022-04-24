@extends('layouts.app')

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('education.show') }}">Обучение</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $resource->title }}</li>
            </ol>
        </nav>
        <h2>{{ $resource->title }}</h2>

        @if(auth()->user()->isAdmin())
            <div class="card p-3">
                <ckeditor v-model="editorData" :config="editorConfig"></ckeditor>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
@endsection
