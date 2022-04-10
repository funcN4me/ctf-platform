@extends('layouts.app')

@section('content')
    <div class="container text-center">
        <h1>Панель администратора</h1>
        <div class="row align-items-start" style="padding-top:10vh">
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header">
                        <span style="font-size: 24px;">
                            {{ __('Задачи') }}
                        </span>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <th>Название</th>
                                <th></th>
                            </thead>
                            <tbody>
                                @foreach($tasks as $task)
                                    <tr>
                                        <td align="left">
                                            {{ $task->name }}
                                        </td>
                                        <td align="right">
                                            <a class="btn btn-sm btn-primary" style="margin-bottom: 1vh;"
                                               href="{{ route('task.edit', $task) }}">Изменить
                                            </a>
                                            <form action="{{ route('task.delete', $task) }}" method="POST">
                                                @method('delete')
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger">Удалить</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header"><h3>{{ __('Обучение') }}</h3></div>
                    <div class="card-body text-start">
                        Название
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header"><h3>{{ __('Задачи') }}</h3></div>
                    <div class="card-body text-start">
                        Название
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
