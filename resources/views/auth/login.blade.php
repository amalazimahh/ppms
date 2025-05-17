@extends('layouts.app', ['class' => 'login-page', 'page' => __('Login Page'), 'contentClass' => 'login-page'])

@section('content')
<div class="login-main-wrapper" style="display:flex;min-height:100vh;align-items:center;">
    <!-- Left: Login Form -->
    <div class="login-left" style="flex:1;display:flex;flex-direction:column;justify-content:center;align-items:center;">
        <div style="max-width:400px;width:100%;">
            <h2 style="color:#1cbfff;font-weight:700;font-size:2rem;margin-bottom:0.5rem;">Welcome Back</h2>
            <form class="form" method="post" action="{{ route('login') }}">
                @csrf
                <div class="form-group" style="margin-bottom:1rem;">
                    <label for="email" style="color:#ffff;font-weight:600;font-size:0.95rem;">Email</label>
                    <input type="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="username@ppms.pwd.gov.bn" value="{{ old('email') }}">
                    @include('alerts.feedback', ['field' => 'email'])
                </div>
                <div class="form-group" style="margin-bottom:1rem;">
                    <label for="password" style="color:#ffff;font-weight:600;font-size:0.95rem;">Password</label>
                    <input type="password" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="password">
                    @include('alerts.feedback', ['field' => 'password'])
                </div>
                <button type="submit" class="btn btn-primary btn-block" style="background:linear-gradient(90deg,#1cbfff,#3a7bd5);border:none;border-radius:8px;font-weight:600;padding:0.75rem 0;font-size:1rem;box-shadow:0 2px 8px rgba(60,180,255,0.15);">SIGN IN</button>
            </form>
            <div style="margin-top:1.5rem;text-align:center;font-size:0.97rem;">
                <span>Forgot your password? Reset password <a href="{{ route('password.request') }}" style="color:#1cbfff;">here</a></span><br>
                <span>Don't have an account? <a href="{{ route('register') }}" style="color:#1cbfff;">Sign up</a></span>
            </div>
        </div>
    </div>
    <!-- Right: Image -->
    <div class="login-right" style="flex:1;display:flex;align-items:stretch;justify-content:flex-end;position:relative;overflow:hidden;">
        <div style="width:100%;height:100%;background:#fff;display:flex;align-items:stretch;justify-content:flex-end;clip-path:polygon(15% 0,100% 0,100% 100%,0 100%);box-shadow:0 8px 32px rgba(60,180,255,0.10);">
            <img src="{{ asset('black') }}/img/curved6.jpg" alt="Login Art" style="width:100%;height:100%;object-fit:cover;">
        </div>
    </div>
</div>
<style>
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
.login-left, .login-right {
    min-height: 0;
}
.login-right > div {
    max-height: 90vh;
}
img {
    max-width: 100%;
    max-height: 100%;
    object-fit: cover;
}
/* Custom switch for Remember me */
.login-left input[type="checkbox"] + span {
    background: #e0e0e0;
    transition: background 0.3s;
}
.login-left input[type="checkbox"]:checked + span {
    background: #1cbfff;
}
.login-left input[type="checkbox"]:checked + span + span {
    left: 18px;
}
.login-left input[type="checkbox"] {
    position: absolute;
    opacity: 0;
    width: 0;
    height: 0;
}
.login-left input[type="checkbox"] + span {
    position: absolute;
    top: 0;
    left: 0;
    width: 36px;
    height: 20px;
    border-radius: 12px;
}
.login-left input[type="checkbox"] + span + span {
    position: absolute;
    top: 2px;
    left: 2px;
    width: 16px;
    height: 16px;
    background: #fff;
    border-radius: 50%;
    box-shadow: 0 1px 4px rgba(0,0,0,0.15);
    transition: left 0.3s;
}
.login-left input[type="checkbox"]:checked + span + span {
    left: 18px;
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
.login-page .container {
  width: 100%;
  padding-right: 0;
  padding-left: 0;
  margin-right: 0;
  margin-left: 0;
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
@endsection

