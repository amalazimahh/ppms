@extends('layouts.app', ['class' => 'login-page', 'page' => __('Reset Password'), 'contentClass' => 'login-page'])

@section('content')
<style>
/* Reuse login page styles */
body, html {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    overflow-x: hidden;
}
.full-page>.content {
    padding-top: 0 !important;
    padding-bottom: 0 !important;
}
.login-page .container {
    width: 100%;
    padding-right: 0;
    padding-left: 0;
    margin-right: auto;
    margin-left: auto;
}
.login-main-wrapper {
    min-height: 100vh;
    height: 100vh;
    overflow: hidden;
}
.login-right, .login-right > div, .login-right img {
    border-radius: 0 !important;
    padding: 0 !important;
    margin: 0 !important;
    height: 100% !important;
    width: 100% !important;
}

.login-right > div {
    max-height: none !important;
    min-height: 100% !important;
}
img {
    max-width: 100%;
    max-height: 100%;
    object-fit: cover;
    display: block;
}
.full-page > .content,
.full-page > .content > .container {
  padding-right: 0 !important;
  margin-right: 0 !important;
}
.login-page .content,
.login-page .container {
  padding-right: 0 !important;
  margin-right: 0 !important;
  width: 100% !important;
  max-width: 100% !important;
}
</style>

<div class="login-main-wrapper" style="display:flex;min-height:100vh;align-items:center;">
    <!-- Left: Reset Form -->
    <div class="login-left" style="flex:1;display:flex;flex-direction:column;justify-content:center;align-items:center;">
        <div style="max-width:400px;width:100%;">
            <h2 style="color:#1cbfff;font-weight:700;font-size:2rem;margin-bottom:0.5rem;">Reset Your Password</h2>
            @include('alerts.success')
            <form class="form" method="POST" action="{{ route('password.update') }}">
                @csrf

                <div class="form-group" style="margin-bottom:1rem;">
                    <label for="email" style="color:#ffff;font-weight:600;font-size:0.95rem;">Email</label>
                    <input type="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" placeholder="username@ppms.pwd.gov.bn" required autofocus>
                    @include('alerts.feedback', ['field' => 'email'])
                </div>

                <div class="form-group" style="margin-bottom:1rem;">
                    <label for="password" style="color:#ffff;font-weight:600;font-size:0.95rem;">New Password</label>
                    <input type="password" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="New password" required>
                    @include('alerts.feedback', ['field' => 'password'])
                </div>

                <div class="form-group" style="margin-bottom:1rem;">
                    <label for="password_confirmation" style="color:#ffff;font-weight:600;font-size:0.95rem;">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm new password" required>
                </div>

                <button type="submit" class="btn btn-primary btn-block" style="background:linear-gradient(90deg,#1cbfff,#3a7bd5);border:none;border-radius:8px;font-weight:600;padding:0.75rem 0;font-size:1rem;box-shadow:0 2px 8px rgba(60,180,255,0.15);">
                    Submit Reset Request
                </button>
            </form>

            <div style="margin-top:1.5rem;text-align:center;font-size:0.97rem;">
                <span>Back to <a href="{{ route('login') }}" style="color:#1cbfff;">Login</a></span>
            </div>
        </div>
    </div>

    <!-- Right: Image -->
    <div class="login-right" style="flex:1;display:flex;align-items:stretch;justify-content:flex-end;position:relative;overflow:hidden;">
        <div style="width:100%;height:100%;background:#fff;display:flex;align-items:stretch;justify-content:flex-end;clip-path:polygon(15% 0,100% 0,100% 100%,0 100%);box-shadow:0 8px 32px rgba(60,180,255,0.10);">
            <img src="{{ asset('black') }}/img/curved6.jpg" alt="Reset Art" style="width:100%;height:100%;object-fit:cover;">
        </div>
    </div>
</div>
@endsection
