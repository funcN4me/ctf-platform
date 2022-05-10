@extends('layouts.new_app')

@section('header', 'Пользователи')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="col-md-9" style="margin: 0 auto">
                <div class="card">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <th style="width: 60%">ФИО</th>
                                <th>Группа</th>
                                <th style="width: 10%"></th>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                @if($user->isAdmin())
                                    @continue
                                @endif
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->group }}</td>
                                    <td align="center"><a class="btn btn-primary" href="{{ route('user.profile', $user->id) }}">Профиль</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
