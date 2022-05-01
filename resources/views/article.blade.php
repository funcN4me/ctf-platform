@extends('layouts.app')

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('education.show') }}">Обучение</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $resource->title }}</li>
            </ol>
        </nav>
        <h2>{{ $resource->title }} @if(auth()->user()->isAdmin()) <a href="{{ route('resource.showEdit', $resource->id) }}" style="font-size: 18px; color: #0a53be">(редактировать)</a> @endif</h2>
            {!! $resource->content !!}
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
