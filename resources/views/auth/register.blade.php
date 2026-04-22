@extends('layouts.app')
@section('title','Register')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="text-center mb-4">
                <h2 style="font-family:'Cormorant Garamond',serif;font-size:2.2rem">Join ReWear</h2>
                <p class="text-muted">Create your account and start shopping</p>
            </div>

            <div class="card border-0 shadow-sm" style="border-radius:0">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-medium">Full Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}" required style="border-radius:0">
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-medium">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}" required style="border-radius:0">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-medium">Password</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                   required style="border-radius:0">
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-medium">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required style="border-radius:0">
                        </div>
                        <button type="submit" class="btn btn-rewear w-100">Create Account</button>
                    </form>
                </div>
            </div>

            <p class="text-center mt-3 text-muted" style="font-size:.9rem">
                Already have an account? <a href="{{ route('login') }}" style="color:#c4786a">Sign in</a>
            </p>
        </div>
    </div>
</div>
@endsection
