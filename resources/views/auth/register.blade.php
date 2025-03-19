@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow-lg p-4 rounded border-0" style="max-width: 400px; width: 100%; background: #fff;">
        
        <!-- Logo Ataraxia -->
        <div class="text-center">
            <h2 class="mb-3" style="font-family: 'Dash Horizon', sans-serif !important; color: #5b2e91; font-weight: bold;">Ataraxia</h2>
            <p class="text-muted">Create your account</p>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                
                <!-- Name -->
                <div class="mb-3">
                    <label for="name" class="form-label text-dark"><i class="fas fa-user"></i> Full Name</label>
                    <input id="name" type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus placeholder="Enter your full name">
                    @error('name')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label text-dark"><i class="fas fa-envelope"></i> Email Address</label>
                    <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required placeholder="Enter your email">
                    @error('email')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label text-dark"><i class="fas fa-lock"></i> Password</label>
                    <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" required placeholder="Enter your password">
                    @error('password')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mb-3">
                    <label for="password-confirm" class="form-label text-dark"><i class="fas fa-lock"></i> Confirm Password</label>
                    <input id="password-confirm" type="password" class="form-control form-control-lg" name="password_confirmation" required placeholder="Confirm your password">
                </div>

                <!-- Register Button -->
                <div class="mt-3">
                    <button type="submit" class="btn w-100 fw-bold text-white" style="background: #5b2e91; border: none; font-size: 18px;">
                        <i class="fas fa-user-plus"></i> {{ __('Register') }}
                    </button>
                </div>

                <!-- Already have an account? -->
                <div class="text-center mt-3">
                    <p class="text-dark">Already have an account? <a href="{{ route('login') }}" class="text-decoration-none fw-bold" style="color: #5b2e91;">Login here</a></p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
