@extends('layouts.app')
@section('style')
<style>
    .edit img {
        min-width: 15px;
        width: 20px;
        height: 20px;

    }

    .edit img {
        fill: greenyellow
    }

    .fa-delete::before {


        content: "\f1f8";
    }

    tbody tr {
        cursor: pointer;
    }

</style>
@endsection
@section('content')
<div class="m-3">

    <div class="bg-light rounded h-100 p-4">

        <div class="d-flex justify-content-between align-items-start">

            <h6 class="mb-4">Tasks</h6>
            @if(Auth::user()->isAdmin())
            <a href="{{ route('tasks.create') }}" class="btn btn-sm btn-success border-0 m-2 mt-0">Create Task</a>
            @endif
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">User</th>
                        <th scope="col">Task</th>
                        <th scope="col">Priority</th>
                        <th scope="col">Start</th>
                        <th scope="col">End</th>
                    </tr>
                </thead>
                <tbody id="sortable">

                    @foreach ($tasks as $key=>$task)
                    <tr data-task-id="{{  $task->id }}">
                        <th scope="row">{{$key+ +1}}</th>
                        <td>{{ $task->user->name }}</td>
                        <td>{{ $task->name }}</td>
                        <td class="priorityCol">{{ $task->priority }}</td>
                        <td>{{ \Carbon\Carbon::parse($task->start)->toDayDateTimeString() }}</td>
                        <td>{{ \Carbon\Carbon::parse($task->end)->toDayDateTimeString() }}</td>

                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>

@endsection

@section('script')
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script>
    $(function() {
        let orders = []
        $("#sortable").sortable({
            revert: true
            , stop: function(event, ui) {
                orders = [];
                $(document).find("tbody tr").each(function(index, val) {
                    orders.push({
                        order: (index + 1)
                        , taskId: $(this).attr('data-task-id')
                    })
                });
                updateOrder(orders);
                tableDraw();


            }
        });





    });

    function tableDraw() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });

        $.ajax({
            type: 'GET'
            , url: "{{ route('tasks.taskTable') }}"
            , data: {}
            , success: function(data) {
                if (data.html) {
                    $('#sortable').html(data.html)
                }
            }
        });

    }

    function updateOrder(data) {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });

        $.ajax({
            type: 'POST'
            , url: "{{ route('tasks.orderUpdate') }}"
            , data: {
                data: data
            , }
            , success: function(data) {
                if (data.success) {
                    toastr.options = {
                        "positionClass": "toast-bottom-right"
                        , "progressBar": true
                        , "closeButton": false
                        , "newestOnTop": false
                    }
                    toastr.success(data.success);
                }
            }
        });
    }

</script>
@endsection
