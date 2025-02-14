@extends('layouts/blankLayout')

@section('title', 'Forgot Password Basic - Pages')

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}">
@endsection

@section('content')
<div class="position-relative">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-4">

            <!-- Forgot Password -->
            <div class="card p-2">
                <!-- Logo -->
                <div class="app-brand justify-content-center mt-5">
                    <a href="{{ url('/') }}" class="app-brand-link gap-2">
                        <span class="app-brand-logo demo">@include('_partials.macros',["height"=>20])</span>
                        <span class="app-brand-text demo text-heading fw-semibold">{{ config('variables.templateName') }}</span>
                    </a>
                </div>
                <!-- /Logo -->
                <div class="card-body mt-2">
                    <h4 class="mb-2">Forgot Password? 🔒</h4>
                    <p class="mb-4">Enter your email and we'll send you an OTP to reset your password</p>

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form id="formAuthentication" class="mb-3" action="{{ route('password.email') }}" method="POST">
                        @csrf
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Enter your email" autofocus>
                            <label for="email">Email</label>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <button id="sendOtpButton" class="btn btn-primary d-grid w-100" disabled>Send OTP</button>
                    </form>

                    <div class="text-center">
                        <a href="{{ url('auth/login-basic') }}" class="d-flex align-items-center justify-content-center">
                            <i class="mdi mdi-chevron-left scaleX-n1-rtl mdi-24px"></i>
                            Back to login
                        </a>
                    </div>
                </div>
            </div>
            <!-- /Forgot Password -->
            <img src="{{ asset('assets/img/illustrations/tree-3.png') }}" alt="auth-tree" class="authentication-image-object-left d-none d-lg-block">
            <img src="{{ asset('assets/img/illustrations/auth-basic-mask-light.png') }}" class="authentication-image d-none d-lg-block" alt="triangle-bg">
            <img src="{{ asset('assets/img/illustrations/tree.png') }}" alt="auth-tree" class="authentication-image-object-right d-none d-lg-block">
        </div>
    </div>
</div>
<script>
  document.addEventListener('DOMContentLoaded', function() {
      const emailInput = document.getElementById('email');
      const sendOtpButton = document.getElementById('sendOtpButton');

      emailInput.addEventListener('input', function() {
          // Regular expression for validating an email
          const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
          if (emailPattern.test(emailInput.value)) {
              sendOtpButton.disabled = false; // Enable button if valid email
          } else {
              sendOtpButton.disabled = true; // Disable button if invalid email
          }
      });
  });
</script>
@endsection
