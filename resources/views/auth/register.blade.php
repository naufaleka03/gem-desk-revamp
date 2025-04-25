@extends('layouts.guest')

@section('content')

<main class="d-flex align-items-center justify-content-center flex-column" style="min-height: 100vh;">
    <form class="form-signin w-25" action="{{route('register.store')}}" method="POST">
        @csrf
        <h1 class="h3 mb-3 fw-normal">Please sign up</h1>

        <div class="form-floating mt-2">
            <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com"
                name="name">
            <label for="floatingInput">Name</label>
        </div>
        <div class="form-floating mt-2">
            <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com"
                name="username">
            <label for="floatingInput">Username</label>
        </div>
        <div class="form-floating mt-2">
            <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com"
                name="email">
            <label for="floatingInput">Email address</label>
        </div>
        <div class="form-floating mt-2">
            <input type="password" class="form-control" id="floatingPassword" placeholder="Password"
                name="password">
            <label for="floatingPassword">Password</label>
        </div>
        <button type="submit" class="btn btn-primary w-100 py-2 my-3">Sign up</button>
    </form>

    <p style="font-size: 14px">Already have an account? <a href="{{route('login')}}"
            class="text-primary fw-semibold text-decoration-none">Sign In</a>
    </p>
</main>

@endsection
