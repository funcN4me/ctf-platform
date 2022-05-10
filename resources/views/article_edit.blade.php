@extends('layouts.new_app')

@section('header')
    {{ $resource->title }}
    <a href="{{ route('resource.show', $resource->id) }}" style="font-size: 18px; color: #0a53be">(просмотр)</a>
@endsection

@section('breadcrumbs')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('education.show') }}">Обучение</a></li>
        <li class="breadcrumb-item active">{{ $resource->title }}</li>
    </ol>
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('resource.edit', $resource->id) }}" method="post">
                @csrf
                @method('put')
                <div class="card p-3">
                    <textarea name="resource_content" id="summernote" required class="form-control" rows="5" placeholder="Content">{!! $resource->content !!}</textarea>
                    <button class="btn btn-success mt-3" type="submit">Отправить</button>
                </div>
            </form>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                codeviewIframeFilter: true
            });
            @if(\Illuminate\Support\Facades\Session::has('success'))
                Swal.fire({
                    position: 'top-center',
                    icon: 'success',
                    title: '{{session('success')}}',
                    backdrop: false,
                    width: '20rem',
                    showConfirmButton: false,
                    timer: 1500
                })
            @endif
        });
    </script>
@endsection
