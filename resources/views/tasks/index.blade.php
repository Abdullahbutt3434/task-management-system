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

</style>
@endsection
@section('content')
<div class="m-3">

    <div class="bg-light rounded h-100 p-4">

        <div class="d-flex justify-content-between align-items-start">

            <h6 class="mb-4">Tasks</h6>
            <a href="{{ route('tasks.create') }}" class="btn btn-sm btn-success border-0 m-2 mt-0">Create Task</a>
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
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $key=>$task)
                    <tr>
                        {{-- <th scope="row">{{$key+ $tasks->firstItem()}}</th> --}}
                        <th scope="row">{{$task->id}}</th>


                        <td>{{ $task->user->name }}</td>
                        <td>{{ $task->name }}</td>
                        <td>{{ $task->priority }}</td>
                        <td>{{ \Carbon\Carbon::parse($task->start)->toDayDateTimeString() }}</td>
                        <td>{{ \Carbon\Carbon::parse($task->end)->toDayDateTimeString() }}</td>
                        <td>
                            <div class="d-flex justify-content-around">
                                <a href="{{ route('tasks.edit', $task->id) }}" class="edit"><img src="{{ asset('img/pen-svg.svg') }}"></a>
                                <form action="{{ route('tasks.destory') }}" method="POST">
                                    @csrf
                                    <input type="text" name="id" value="{{ $task->id }}" hidden>
                                    <button type="submit" class="edit border-0"><img src="{{ asset('img/prime.svg') }}"></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- {{ $tasks->links() }} --}}

        </div>
    </div>
</div>

@endsection
