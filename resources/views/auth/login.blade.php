@extends('layouts.app')
@section('title','Login')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="text-center mb-4">
                <h2 style="font-family:'Cormorant Garamond',serif;font-size:2.2rem">Welcome Back</h2>
                <p class="text-muted">Sign in to your ReWear account</p>
            </div>

            <div class="card border-0 shadow-sm" style="border-radius:0">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-medium">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}" required autofocus style="border-radius:0">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-medium">Password</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                   required style="border-radius:0">
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Remember me</label>
                        </div>
                        <button type="submit" class="btn btn-rewear w-100">Sign In</button>
                    </form>
                </div>
            </div>

            <p class="text-center mt-3 text-muted" style="font-size:.9rem">
                Don't have an account? <a href="{{ route('register') }}" style="color:#c4786a">Create one</a>
            </p>
        </div>
    </div>
</div>
@endsection
