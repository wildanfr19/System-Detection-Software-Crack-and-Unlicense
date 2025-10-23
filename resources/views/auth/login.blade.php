@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center justify-content-center" style="min-height:70vh;">
    <div class="card shadow-sm" style="width:420px; border-radius:12px; overflow:hidden;">
        <div style="background:linear-gradient(135deg,#0f62a8,#3c8dbc); padding:28px 24px; color:white;">
            <h3 class="mb-0" style="font-weight:700; letter-spacing:0.2px;">Sign in</h3>
            <small class="text-white-50">Access your System Detector dashboard</small>
        </div>
        <div class="p-4" style="background:#fff;">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label small text-muted">Email address</label>
                    <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label small text-muted">Password</label>
                    <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label small text-muted" for="remember">Remember me</label>
                    </div>
                    @if (Route::has('password.request'))
                        <a class="small" href="{{ route('password.request') }}">Forgot?</a>
                    @endif
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg" style="border-radius:10px;">Sign in</button>
                </div>

                <div class="text-center mt-3">
                    <small class="text-muted">Need an account? <a href="{{ route('register') }}">Register</a></small>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
