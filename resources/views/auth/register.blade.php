@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center justify-content-center" style="min-height:70vh;">
    <div class="card shadow-sm" style="width:520px; border-radius:12px; overflow:hidden;">
        <div style="background:linear-gradient(135deg,#0f62a8,#3c8dbc); padding:28px 24px; color:white;">
            <h3 class="mb-0" style="font-weight:700; letter-spacing:0.2px;">Create account</h3>
            <small class="text-white-50">Register to access System Detector</small>
        </div>
        <div class="p-4" style="background:#fff;">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="row g-3">
                    <div class="col-12">
                        <label for="name" class="form-label small text-muted">Full name</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12">
                        <label for="email" class="form-label small text-muted">Email address</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label for="password" class="form-label small text-muted">Password</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label for="password-confirm" class="form-label small text-muted">Confirm password</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-primary btn-lg" style="border-radius:10px;">Create account</button>
                </div>

                <div class="text-center mt-3">
                    <small class="text-muted">Already have an account? <a href="{{ route('login') }}">Sign in</a></small>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
