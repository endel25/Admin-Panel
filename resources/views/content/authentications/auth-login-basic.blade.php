@extends('layouts/blankLayout')

@section('title', 'Login Basic - Pages')

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}">
@endsection

@section('content')
<div class="position-relative">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-4">
            <!-- Login -->
            <div class="card p-2">
                <!-- Logo -->
                <div class="app-brand justify-content-center mt-5">
                    <a href="{{ url('/') }}" class="app-brand-link gap-2">
                        <span class="app-brand-logo demo">@include('_partials.macros', ["height" => 20, "withbg" => 'fill: #fff;'])</span>
                        <span class="app-brand-text demo text-heading fw-semibold">{{ config('variables.templateName') }}</span>
                    </a>
                </div>
                <!-- /Logo -->

                <div class="card-body mt-2">
                    <h4 class="mb-2">Welcome to {{ config('variables.templateName') }}! 👋</h4>
                    <p class="mb-4">Please sign in to your account and start the adventure</p>

                    @if(session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form id="formAuthentication" class="mb-3" action="{{ route('form-data-fetch') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Enter your email or username" autofocus value="{{ old('email') }}">
                            <label for="email">Email or Username</label>
                            @error('email')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-password-toggle">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                                        <label for="password">Password</label>
                                    </div>
                                    {{-- <span class="input-group-text cursor-pointer" id="toggle-password"><i class="mdi mdi-eye-off-outline"></i></span> --}}
                                    @error('password')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 d-flex justify-content-between">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember-me">
                                <label class="form-check-label" for="remember-me">Remember Me</label>
                            </div>
                            <a href="{{ url('auth/forgot-password-basic') }}" class="float-end mb-1"><span>Forgot Password?</span></a>
                        </div>

                        <div class="mb-3">
                            <button id="sign-in-btn" class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                        </div>
                    </form>

                    <p class="text-center">
                        <span>New on our platform?</span>
                        <a href="{{ url('auth/register-basic') }}"><span>Create an account</span></a>
                    </p>
                </div>
            </div>
            <!-- /Login -->

            <!-- Illustrations -->
            <img src="{{ asset('assets/img/illustrations/tree-3.png') }}" alt="auth-tree" class="authentication-image-object-left d-none d-lg-block">
            <img src="{{ asset('assets/img/illustrations/auth-basic-mask-light.png') }}" alt="triangle-bg" class="authentication-image d-none d-lg-block">
            <img src="{{ asset('assets/img/illustrations/tree.png') }}" alt="auth-tree" class="authentication-image-object-right d-none d-lg-block">
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Initialize Toastr options
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right"
        };

        // Display success message from session
        @if(session('status'))
            toastr.success("{{ session('status') }}");
        @endif

        // Disable sign-in button initially
        // $('#sign-in-btn').prop('disabled', true);

        // // Function to validate inputs
        // function checkInputs() {
        //     let email = $('#email').val().trim();
        //     let password = $('#password').val().trim();

        //     // Enable button only if both fields are filled
        //     $('#sign-in-btn').prop('disabled', !(email.length > 0 && password.length > 0));
        // }

        // // Listen for input events on both fields
        // $('#email, #password').on('input', checkInputs);

        // // Ensure button is checked on page load (if autofill happens)
        // checkInputs();

        // // Toggle password visibility
        // $('#toggle-password').on('click', function() {
        //     const passwordInput = $('#password');
        //     const passwordType = passwordInput.attr('type') === 'password' ? 'text' : 'password';
        //     passwordInput.attr('type', passwordType);
        //     $(this).find("i").toggleClass("mdi-eye-off-outline mdi-eye-outline");
        // });
    });
</script>
@endsection
