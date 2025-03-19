@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center min-vh-100" style="background: linear-gradient(135deg,rgb(0, 0, 0), #5b2e91);">
    <div class="card shadow-lg p-4 rounded border-0" style="max-width: 400px; width: 100%; background: #fff;">
        <div class="card-header text-center rounded" style="background: #5b2e91; color: #fff;">
            <h2 class="mb-0" style="font-family: 'Dash Horizon', sans-serif;">Ataraxia</h2>
        </div>
        
        <div class="card-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label text-dark"><i class="fas fa-envelope"></i> Email Address</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Masukkan email Anda">
                    @error('email')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label text-dark"><i class="fas fa-lock"></i> Password</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Masukkan password Anda">
                    @error('password')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label text-dark" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>

                    @if (Route::has('password.request'))
                        <a class="text-decoration-none" href="{{ route('password.request') }}" style="color: #5b2e91;">
                            {{ __('Forgot Password?') }}
                        </a>
                    @endif
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-dark w-100 fw-bold" style="background: #5b2e91; border: none;">
                        <i class="fas fa-sign-in-alt"></i> {{ __('Login') }}
                    </button>
                </div>

                <div class="text-center mt-3">
                    <p class="text-dark">Belum punya akun? <a href="{{ route('register') }}" class="text-decoration-none fw-bold" style="color: #5b2e91;">Daftar sekarang</a></p>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Tambahkan FontAwesome & Font Dash Horizon -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<link href="https://fonts.cdnfonts.com/css/dash-horizon" rel="stylesheet">

<style>
    h2 {
        font-family: 'Dash Horizon', sans-serif !important;
    }
</style>
