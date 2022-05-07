@extends('layouts.new_app')

@section('content')
    <div class="container">
        <div class="row justify-content-start">
            @foreach(\App\Models\Category::all() as $category)
                @if($category->tasks->count() !== 0)
                    <span class="category_name">{{ $category->name }}</span>
                @endif
                @foreach($tasks as $task)
                    @if($task->category->name == $category->name)
                        <div class="col-md-3 mb-4">
                            <div id="showTask" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                 data-id="{{ $task->id }}">
                                <div class="card @if(auth()->user()->tasks->contains($task->id)) text-white bg-success @endif task-card">
                                    <div class="card-header" style="max-height: 5em;">{{ $task->subcategory }}</div>
                                    <div class="card-body" style="min-height: 8em;">
                                        {{ $task->name }}
                                        @if(auth()->user()->isAdmin())
                                            <div class="container align-text-bottom text-end" style="padding-top: 4vh;margin-left: 1.5em;">
                                                <a class="task-edit" href="{{ route('task.edit', $task->id) }}" style="border: 1px solid black; border-radius: 25px; padding: 8px;"><img src="{{ asset('images/pen.svg') }}" alt="" width="20px"></a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @endforeach
        </div>
    </div>
    <!-- Modal -->
    <div class="modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('tasks.check') }}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="font-size: 16px;">
                        <input id="task_id" type="text" name="task_id" hidden>
                        <p id="modal-description"></p>
                        <span id="modal-link">Ссылка на задание: <a id="modal-url" href="" style="color: #0a53be" target="_blank"></a></span>
                        <br>
                        <br>
                        <span id="modal-attach" class="mt-2">Файлы для задания:</span>
                        <div id="modal-attachments">
                        </div>
                        <br>
                        <label for="flag">Флаг:</label>
                        <input id="flag" name="flag" type="text" class="form-control" placeholder="4hsl33p{...}">
                    </div>
                    <div class="modal-footer">
                        <button id="submit-flag" type="submit" class="btn btn-primary">Отправить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#submit-flag').click(function (e) {
                e.preventDefault();
                let task_id = $('#task_id').val();
                let flag = $('#flag').val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    type: "POST",
                    url: '{{ route('tasks.check') }}',
                    data: {'_token':_token,'task_id':task_id,'flag':flag},
                    success: function (resp) {
                        console.log(resp);
                        if (resp.success) {
                            Swal.fire({
                                position: 'top-center',
                                icon: 'success',
                                title: 'Верно',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            setTimeout(function () {
                                location.reload(true);
                            }, 1500);
                        }
                        else {
                            Swal.fire({
                                position: 'top-center',
                                icon: 'error',
                                title: 'Не верно',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    }
                }).fail(function (resp) {
                    Swal.fire({
                        position: 'top-center',
                        icon: 'error',
                        title: resp.responseJSON.errors.flag[0],
                        showConfirmButton: false,
                        timer: 1500
                    });
                });
            });
        });

        $('body').on('click', '.task-edit', function (event) {
            event.prevent();
        });
        $('body').on('click', '#showTask', function (event) {
            event.preventDefault();
            var id = $(this).data('id');
            console.log(id);
            $.get('task/' + id, function (data) {
                let url = data.data.url;
                $('#flag').val("");
                console.log(data.data);
                console.log(data);
                $('#exampleModalLabel').text(data.data.name);
                $('#modal-description').text(data.data.description);
                $('#modal-url').text(data.data.url);
                $('#modal-url').attr("href", data.data.url);
                $('#task_id').val(data.data.id);

                if (!url) {
                    $('#modal-link').hide();
                }
                else {
                    $('#modal-link').show();
                }
                let attachments = document.getElementById('modal-attachments');
                let p = document.createElement('p');
                p.text = 'Файлы к заданию';
                attachments.append(p);

                let child = attachments.lastElementChild;
                while (child) {
                    attachments.removeChild(child);
                    child = attachments.lastElementChild;
                }

                if (data.attachments.length !== 0) {
                    $('#modal-attach').show();
                    if(attachments.childElementCount === 0) {
                        $.each(data.attachments, function (index, value) {
                            let a = document.createElement('a');
                            a.text = value.name;
                            a.classList = ['links'];
                            a.href = value.file_path;
                            attachments.append(a);
                            attachments.append(document.createElement('br'));
                        });
                    }
                }
                else {
                    $('#modal-attach').hide();
                    let child = attachments.lastElementChild;
                    while (child) {
                        attachments.removeChild(child);
                        child = attachments.lastElementChild;
                    }
                }

                $('#exampleModal').modal('show');
            })
        });

    </script>
@endsection
