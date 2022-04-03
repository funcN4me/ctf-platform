@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Пользователь {{ $user->name }}
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('ФИО') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ $user->name }}" required autocomplete="name" autofocus disabled>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Email адрес') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ $user->email }}" required autocomplete="name" autofocus disabled>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Группа') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ $user->group }}" required autocomplete="name" autofocus disabled>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Дата создания профиля') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ \Illuminate\Support\Carbon::createFromFormat('Y-m-d H:i:s', $user->created_at)->format('d.m.Y H:i:s') }}" required autocomplete="name" autofocus disabled>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Дата обновления профиля') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ \Illuminate\Support\Carbon::createFromFormat('Y-m-d H:i:s', $user->updated_at)->format('d.m.Y H:i:s') }}" required autocomplete="name" autofocus disabled>
                            </div>
                        </div>
                        @if($user->tasks->count() == 0)
                            <div class="container text-center mt-5">
                                <span style="font-size: 16px; color: red">Пользователь пока не решил ни одной задачи</span>
                            </div>
                        @else
                            <span class="m-1">Решённые задачи</span>
                            <table class="table">
                                <thead>
                                    <th>Название</th>
                                    <th>Категория</th>
                                    <th>Подкатегория</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    @foreach($user->tasks as $task)
                                        <tr>
                                            <td>{{ $task->name }}</td>
                                            <td>{{ $task->category->name }}</td>
                                            <td>{{ $task->sub_category }}</td>
                                            <td></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
