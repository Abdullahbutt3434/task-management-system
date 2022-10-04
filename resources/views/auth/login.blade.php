@extends('layouts.app')

@section('content')

<!-- Sign In Start -->
<div class="container-fluid">
    <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
            <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <a href="index.html" class="">
                        <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>Task Management</h3>
                    </a>
                    <h3>Sign In</h3>
                </div>
                <form action="{{ route('login.post') }}" method="POST">
                    @csrf
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" name="email" id="floatingInput" placeholder="name@example.com">
                        <label for="floatingInput">Email address</label>
                        @if ($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif

                    </div>
                    <div class="form-floating mb-4">
                        <input type="password" class="form-control" name="password" id="floatingPassword" placeholder="Password">
                        <label for="floatingPassword">Password</label>
                        @if ($errors->has('password'))
                        <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif

                    </div>
                    <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Sign In</button>
                </form>
                <p class="text-center mb-0">Don't have an Account? <a href="">Sign Up</a></p>
            </div>
        </div>
    </div>
</div>
<!-- Sign In End -->

@endsection
