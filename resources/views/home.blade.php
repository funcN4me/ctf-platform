@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header h1">Здравствуйте, {{auth()->user()->name}}!</div>

        <div class="card-body">
            <h2>Добро пожаловать на CTF-Платформу!</h2>
            <hr>
            <h3>Данная платформа предназначена для введения студентов в движение CTF.
                <br>
                <br>
                На нашей платформе Вы можете порешать задачи на определённые виды уязвимостей, почитать теорию по той или иной уязвимости.
            </h3>
        </div>
    </div>
</div>
@endsection
