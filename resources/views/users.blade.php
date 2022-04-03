@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Пользователи
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <th>ФИО</th>
                                <th>Группа</th>
                                <th></th>
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
    </div>
@endsection
