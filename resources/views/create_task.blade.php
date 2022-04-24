@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Создать задачу') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('tasks.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Название задачи') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

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
                                    <select name="category" class="form-select @error('category') is-invalid @enderror" id="create_category" required>
                                        <option>Выберите категорию из списка</option>
                                        @foreach($categories as $key => $value)
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
                                    <input id="subcategory" type="text" class="form-control @error('subcategory') is-invalid @enderror" name="subcategory" value="{{ old('subcategory') }}" required autocomplete="subcategory">

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
                                                <option value="{{ $resource->id }}">{{ $resource->title }}</option>
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
                                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" style="height: 10em;">{{ old('description') }}</textarea>
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
                                    <input class="form-control @error('url') is-invalid @enderror" type="url" id="url" name="url">
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
                                    <input class="form-control @error('flag') is-invalid @enderror" type="text" id="flag" name="flag" value="{{ old('flag') }}">
                                    <span style="font-size: 0.85em; font-weight: bold;color: red">*Префикс 4hsl33p{...} выставится автоматически</span>
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
                                        {{ __('Создать') }}
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
            $("#add_resource_btn").on('click', function () {
                $(".resources").last().after(
                    "<input id=\"resources\" type=\"text\" class=\"resources form-control mt-3\" required name=\"new_resources[]\">"
                );
                if(!$("#remove_resource_btn").length) {
                    $("#control-btns").append(
                        "<div class=\"mt-3\">" +
                            "<button type='button' id=\"remove_resource_btn\" class='btn-sm btn-danger'>Удалить ресурс</button>" +
                        "</div"
                    );
                    $("#remove_resource_btn").on("click", function () {
                        $(".resources").last().remove();
                        if ($(".resources").length === 1) {
                            this.remove()
                        }
                    });
                }
            });
                if($('#success').length) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Задача добавлена',
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
