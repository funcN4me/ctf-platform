@extends('layouts.app')

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('education.show') }}">Обучение</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $resource->title }}</li>
            </ol>
        </nav>
        <h2>{{ $resource->title }} <a href="{{ route('resource.show', $resource->id) }}" style="font-size: 18px; color: #0a53be">(просмотр)</a></h2>
        <form action="{{ route('resource.edit', $resource->id) }}" method="post">
            @csrf
            @method('put')
            <div class="card p-3">
                <textarea name="resource_content" id="content" required class="form-control" rows="5" placeholder="Content">{!! $resource->content !!}</textarea>

                <button class="btn btn-success mt-3" type="submit">Отправить</button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('/ckeditor/adapters/jquery.js') }}"></script>
    <script>
        $(document).ready(function () {
            CKEDITOR.replace( 'content' );
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
