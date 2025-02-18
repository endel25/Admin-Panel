@extends('layouts/blankLayout')

@section('title', 'Forgot Password Basic - Pages')

@section('page-style')
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}">
    <style>
        /* Styles for the loading overlay */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5); /* Semi-transparent black background */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 1000; /* Ensure it's on top of everything */
            color: white; /* Text color */
            font-size: 1.2rem; /* Font size */
            text-align: center; /* Center text */
            display: none; /* Initially hidden */
        }

        .loader {
            border: 8px solid #f3f3f3; /* Light grey */
            border-top: 8px solid #3498db; /* Blue */
            border-radius: 50%;
            width: 60px; /* Increased size for better visibility */
            height: 60px; /* Increased size for better visibility */
            animation: spin 1s linear infinite;
            margin-bottom: 20px; /* Space between loader and text */
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
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

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loader"></div>
        <p>Sending OTP, please wait...</p> <!-- Informative message -->
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const emailInput = document.getElementById('email');
            const sendOtpButton = document.getElementById('sendOtpButton');
            const loadingOverlay = document.getElementById('loadingOverlay');

            emailInput.addEventListener('input', function() {
                // Regular expression for validating an email
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                sendOtpButton.disabled = !emailPattern.test(emailInput.value); // Enable or disable button based on email validity
            });

            sendOtpButton.addEventListener('click', function(event) {
                // Prevent default form submission to handle it manually
                event.preventDefault();

                // Show the loading overlay
                loadingOverlay.style.display = 'flex';

                // Disable the button
                sendOtpButton.disabled = true;

                // Submit the form programmatically
                document.getElementById('formAuthentication').submit();

                // Note: Remove the simulated delay in production.
                // The loading overlay will automatically hide when the page reloads.
            });
        });
    </script>
@endsection
