@extends('layouts.app', ['class' => 'register-page', 'page' => __('Register Page'), 'contentClass' => 'register-page'])

@section('content')
<div class="register-main-wrapper" style="display:flex;min-height:100vh;align-items:center;">
    <!-- Left: Registration Form -->
    <div class="register-left" style="flex:1;display:flex;flex-direction:column;justify-content:center;align-items:center;">
        <div style="max-width:400px;width:100%;">
            <h2 style="color:#1cbfff;font-weight:700;font-size:2rem;margin-bottom:0.5rem;">Create Account</h2>
            <form class="form" method="post" action="{{ route('register') }}">
                @csrf
                <div class="form-group" style="margin-bottom:1rem;">
                    <label for="name" style="color:#ffff;font-weight:600;font-size:0.95rem;">Name</label>
                    <input type="text" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}">
                    @include('alerts.feedback', ['field' => 'name'])
                </div>
                <div class="form-group" style="margin-bottom:1rem;">
                    <label for="email" style="color:#ffff;font-weight:600;font-size:0.95rem;">Email</label>
                    <input type="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}">
                    @include('alerts.feedback', ['field' => 'email'])
                </div>
                <div class="form-group" style="margin-bottom:1rem;">
                    <label for="password" style="color:#ffff;font-weight:600;font-size:0.95rem;">Password</label>
                    <input type="password" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('Password') }}">
                    @include('alerts.feedback', ['field' => 'password'])
                </div>
                <div class="form-group" style="margin-bottom:1rem;">
                    <label for="password_confirmation" style="color:#ffff;font-weight:600;font-size:0.95rem;">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="{{ __('Confirm Password') }}">
                </div>
                <div class="form-check text-left" style="margin-bottom:1rem;">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox">
                        <span class="form-check-sign"></span>
                        {{ __('I agree to the') }}
                        <a href="#">{{ __('terms and conditions') }}</a>.
                    </label>
                </div>
                <div class="card-footer" style="background:none;border:none;padding:0;">
                    <button type="submit" class="btn btn-primary btn-block" style="background:linear-gradient(90deg,#1cbfff,#3a7bd5);border:none;border-radius:8px;font-weight:600;padding:0.75rem 0;font-size:1rem;box-shadow:0 2px 8px rgba(60,180,255,0.15);">{{ __('Get Started') }}</button>
                </div>
            </form>
            <div style="margin-top:1.5rem;text-align:center;font-size:0.97rem;">
                <span>Already have an account? <a href="{{ route('login') }}" style="color:#1cbfff;">Login</a></span>
            </div>
        </div>
    </div>
    <!-- Right: Image -->
    <div class="register-right" style="flex:1;display:flex;align-items:stretch;justify-content:flex-end;position:relative;overflow:hidden;">
        <div style="width:100%;height:100%;background:#fff;display:flex;align-items:stretch;justify-content:flex-end;clip-path:polygon(15% 0,100% 0,100% 100%,0 100%);box-shadow:0 8px 32px rgba(60,180,255,0.10);">
            <img src="{{ asset('black') }}/img/curved6.jpg" alt="Register Art" style="width:100%;height:100%;object-fit:cover;">
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

.register-page .container {
  width: 100%;
  padding-right: 0;
  padding-left: 0;
  margin-right: auto;
  margin-left: auto;
}

.register-main-wrapper {
    min-height: 100vh;
    height: 100vh;
    overflow: hidden;
}
.register-left, .register-right {
    min-height: 0;
}
.register-right > div {
    max-height: 90vh;
}
img {
    max-width: 100%;
    max-height: 100%;
    object-fit: cover;
}

.register-right, .register-left > div, .register-right img {
    border-radius: 0 !important;
    padding: 0 !important;
    margin: 0 !important;
    height: 100% !important;
    width: 100% !important;
}
.register-right > div {
    max-height: none !important;
    min-height: 100% !important;
}
img {
    max-width: 100%;
    max-height: 100%;
    object-fit: cover;
    display: block;
}
.register-page .container {
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
.register-page .content,
.register-page .container {
  padding-right: 0 !important;
  margin-right: 0 !important;
  width: 100% !important;
  max-width: 100% !important;
}
</style>
@endsection

