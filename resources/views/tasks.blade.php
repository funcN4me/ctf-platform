@extends('layouts.app')

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
                            <div id="showTask" style="cursor: pointer;" data-toggle="modal" data-target="#exampleModal"
                                 data-id="{{ $task->id }}">
                                <div class="card @if(auth()->user()->tasks->contains($task->id)) text-white bg-success @endif">
                                    <div class="card-header" style="max-height: 5em;">{{ $task->sub_category }}</div>
                                    <div class="card-body" style="min-height: 8em;">
                                        {{ $task->name }}
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
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('tasks.check') }}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input id="task_id" type="text" name="task_id" hidden>
                        <p id="modal-description"></p>
                        <span id="modal-link">Ссылка на задание <a id="modal-url" href=""></a></span>
                        <span id="modal-attach">Файлы для задания:</span>
                        <div id="modal-attachments">
                        </div>
                        <br>
                        <label for="flag">Флаг:</label>
                        <input id="flag" name="flag" type="text" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button id="submit-flag" type="submit" class="btn btn-primary">Save changes</button>
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
                                position: 'top-end',
                                icon: 'success',
                                title: 'Верно',
                                showConfirmButton: false,
                                timer: 1000
                            });
                        }
                        else {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'error',
                                title: 'Не верно',
                                showConfirmButton: false,
                                timer: 1000
                            });
                        }
                    }
                }).fail(function (resp) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: resp.responseJSON.errors.flag[0],
                        showConfirmButton: false,
                        timer: 1000
                    });
                });
            });
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
