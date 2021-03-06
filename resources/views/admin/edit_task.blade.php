@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Изменить задачу') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('task.update', $task) }}" enctype="multipart/form-data">
                            @method('put')
                            @csrf
                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Название задачи') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $task->name }}" required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            @if($errors->any())
                                {{ $errors->first() }}
                            @endif

                            <div class="row mb-3">
                                <label for="category" class="col-md-4 col-form-label text-md-end">{{ __('Категория') }}</label>

                                <div class="col-md-6">
                                    <select name="category" class="form-select @error('category') is-invalid @enderror" id="create_category">
                                        <option>{{ $task->category->name }}</option>

                                    @foreach($categories as $key => $value)
                                        @if($task->category->name == $value->name)
                                            @continue
                                        @endif
                                        <option value="{{ $value->name }}">
                                        {{ $value->name }}
                                        </option>
                                    @endforeach
                                        <option value="Other">
                                            Категории нет в списке
                                        </option>
                                    </select>

                                    @error('category')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div id="div-new-category" class="row mb-3" hidden>
                                <label id="label-new-category" for="new-category" class="col-md-4 col-form-label text-md-end" hidden>{{ __('Введите название') }}</label>
                                <div class="col-md-6">
                                    <input id="new-category" type="text" class="form-control @error('new_category') is-invalid @enderror" name="new_category" hidden>

                                    @error('new_category')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="subcategory" class="col-md-4 col-form-label text-md-end">{{ __('Подкатегория') }}</label>

                                <div class="col-md-6">
                                    <input id="subcategory" type="text" class="form-control @error('subcategory') is-invalid @enderror" name="subcategory" value="{{ $task->subcategory }}" required autocomplete="subcategory">

                                    @error('subcategory')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <p class="col-md-4 col-form-label text-md-end">{{ __('Ресурсы для решения') }}</p>

                                <div class="col-md-6">
                                    @if($resources->isNotEmpty())
                                        <span style="font-size: 0.85em; font-weight: bold;color: red">Выберите ресурсы из списка (чтобы отменить выбор ресурса или выбрать несколько - нажмите на него с зажатой клавишей Ctrl)</span>
                                        <select name="resources[]" class="form-select" multiple>
                                            @foreach($resources as $resource)
                                                <option value="{{ $resource->id }}" @if($task->resources->contains($resource)) selected @endif>{{ $resource->title }}</option>
                                            @endforeach
                                        </select>
                                        <br>
                                        <input id="resources" type="text" class="resources form-control @error('resources') is-invalid @enderror" name="new_resources[]" value="" autocomplete="resources" placeholder="Название нового ресурса">
                                    @else
                                        <input id="resources" type="text" class="resources form-control @error('resources') is-invalid @enderror" name="new_resources[]" value="" autocomplete="resources" required placeholder="Название нового ресурса">
                                    @endif
                                    <br>
                                    <div id="control-btns" class="container text-end">
                                        <button id="add_resource_btn" type="button" class="btn btn-sm btn-secondary">Добавить ещё один ресурс</button>
                                    </div>
                                    @error('resources')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="description" class="col-md-4 col-form-label text-md-end">{{ __('Описание') }}</label>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" style="height: 10em;">{{ $task->description }}</textarea>
                                        <label for="description">Описание</label>
                                    </div>
                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="files" class="col-md-4 col-form-label text-md-end">{{ __('Вложения') }}</label>
                                <div class="col-md-6">
                                    <input name="attachments[]" class="form-control" type="file" id="files" multiple>
                                    <div class="d-flex text-center justify-content-center" id="taskContainer">
                                        <div class="row">
                                        @foreach($task->attachments as $attachment)
                                            <div class="col-5">
                                                <div class="card" style="width: 8rem; margin-top: 20px; background-color: #E9ECEFFF;">
                                                    <div class="card-header text-end">
                                                        <a id="attachmentDelete" href="#" data-id="{{ $attachment->id }}">
                                                            <img src="{{ asset('images/xmark.svg') }}" alt="" width="20px">
                                                        </a>
                                                    </div>
                                                    <a href="{{ $attachment->file_path }}">
                                                        <div class="card-body text-center" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis">
                                                            {{ $attachment->name }}
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                        </div>
                                    </div>
                                    @error('attachments')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="url" class="col-md-4 col-form-label text-md-end">{{ __('Ссылка на задачу') }}</label>

                                <div class="col-md-6">
                                    <input class="form-control" type="url" id="url" name="url" value="{{ $task->url }}">
                                    @error('url')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="flag" class="col-md-4 col-form-label text-md-end">{{ __('Флаг') }}</label>

                                <div class="col-md-6">
                                    <input class="form-control" type="text" id="flag" name="flag" value="{{ $task->flag }}">
                                    @error('flag')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                @if(session('success'))
                                    <small id="success" hidden>{{ session('success') }}</small>
                                @endif
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Изменить') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("#create_category").on('change', function () {
                if ($("#create_category").val() === "Other") {
                    $("#new-category").attr('hidden', false);
                    $("#label-new-category").attr('hidden', false);
                    $("#div-new-category").attr('hidden', false);
                }
                else {
                    $("#new-category").attr('hidden', true);
                    $("#new-category").val('');
                    $("#label-new-category").attr('hidden', true);
                    $("#div-new-category").attr('hidden', true);
                }
            });
            $('body').on('click', '#attachmentDelete', function (event) {
                var id = $(this).data('id');
                $.ajax({
                    type: "DELETE",
                    url: '/task/attachment/' + id,
                    success: function (resp) {
                        if (resp.response === 'successful') {
                            $(this).remove();
                            $('#taskContainer').load(location.href + " #taskContainer");
                        }
                    }
                });
            });
                if($('#success').length) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Задача обновлена',
                        backdrop: false,
                        width: '20rem',
                        showConfirmButton: false,
                        timer: 1000
                    })
                }
            }
        );
    </script>
@endsection
