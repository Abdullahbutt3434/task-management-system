@extends('layouts.app')

@section('content')
<div class="m-3">
    <div class="bg-light rounded h-100 p-4">
        <h6 class="mb-4">Users</h6>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $key=>$user)
                    <tr>
                        <th scope="row">{{$key+1}}</th>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role == config('global.role.ROLE_ADMIN') ? 'Admin':'User' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
