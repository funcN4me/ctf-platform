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
            <form action="{{ route('resource.edit', $resource->id) }}" method="post">
                @csrf
                @method('put')
                <div class="card p-3">
                    <text-article v-model="editorData" :config="editorConfig"></text-article>
                </div>
                <button class="btn btn-success" type="submit">Отправить</button>
            </form>
        @endif
    </div>
@endsection

@section('scripts')
@endsection
