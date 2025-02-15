@extends('layouts/blankLayout')

@section('title', 'Register Basic - Pages')

@section('page-style')
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}">
    <!-- Include SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
@endsection

@section('content')
    <div class="position-relative">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-4">

                <!-- Register Card -->
                <div class="card p-2">
                    <!-- Logo -->
                    <div class="app-brand justify-content-center mt-5">
                        <a href="{{ url('/') }}" class="app-brand-link gap-2">
                            <span class="app-brand-logo demo">@include('_partials.macros', ["height"=>20])</span>
                            <span class="app-brand-text demo text-heading fw-semibold">{{ config('variables.templateName') }}</span>
                        </a>
                    </div>
                    <!-- /Logo -->
                    <div class="card-body mt-2">
                        <h4 class="mb-2">Adventure starts here 🚀</h4>
                        <p class="mb-4">Make your app management easy and fun!</p>

                        <form id="formAuthentication" class="mb-3" action="{{ route('form-data-store') }}" method="post">
                            @csrf
                            <div class="form-floating form-floating-outline mb-3">
                                <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" placeholder="Enter your username" autofocus value="{{ old('username') }}">
                                <label for="username">Username</label>
                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-floating form-floating-outline mb-3">
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Enter your email" value="{{ old('email') }}">
                                <label for="email">Email</label>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <div id="email-error" class="text-danger"></div>  <!-- Error message for email -->
                            </div>

                            <!-- OTP Section -->
                            <div class="mb-3 d-flex align-items-center">
                                <div class="form-floating form-floating-outline flex-grow-1">
                                    <input type="text" class="form-control @error('otp') is-invalid @enderror" id="otp" name="otp" placeholder="Enter OTP" maxlength="6" disabled value="{{ old('otp') }}">
                                    <label for="otp">OTP</label>
                                    @error('otp')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <button type="button" class="btn btn-outline-primary ms-2" id="sendOtp">Send OTP</button>
                            </div>
                            <!-- /OTP Section -->

                            <div class="mb-3 form-password-toggle">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                                        <label for="password">Password</label>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    {{-- <span class="input-group-text cursor-pointer"><i class="mdi mdi-eye-off-outline"></i></span> --}}
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input @error('terms') is-invalid @enderror" type="checkbox" id="terms-conditions" name="terms">
                                    <label class="form-check-label" for="terms-conditions">
                                        I agree to
                                        <a href="javascript:void(0);">privacy policy & terms</a>
                                    </label>
                                    @error('terms')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <button class="btn btn-primary d-grid w-100" type="submit" id="registerButton" disabled>
                                Sign up
                            </button>
                        </form><p class="text-center">
                            <span>Already have an account?</span>
                            <a href="{{ url('auth/login-basic') }}">
                                <span>Sign in instead</span>
                            </a>
                        </p>
                    </div>
                </div>
                <!-- Register Card -->
                <img src="{{ asset('assets/img/illustrations/tree-3.png') }}" alt="auth-tree" class="authentication-image-object-left d-none d-lg-block">
                <img src="{{ asset('assets/img/illustrations/auth-basic-mask-light.png') }}" class="authentication-image d-none d-lg-block" alt="triangle-bg">
                <img src="{{ asset('assets/img/illustrations/tree.png') }}" alt="auth-tree" class="authentication-image-object-right d-none d-lg-block">
            </div>
        </div>
    </div>

    @push('scripts')  <!-- Use push to include scripts -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- Include SweetAlert JS -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#sendOtp').click(function() {
                    var email = $('#email').val();
                    $('#email-error').text(''); // Clear previous errors

                    if (!email) {
                        $('#email-error').text('Email is required.');
                        return;
                    }

                    $.ajax({
                        url: "{{ route('send-otp') }}", // Ensure this route is defined
                        type: "POST",
                        data: {
                            email: email,
                            _token: "{{ csrf_token() }}"
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                $('#otp').prop('disabled', false);
                                $('#registerButton').prop('disabled', false);
                                // Use SweetAlert for success message
                                Swal.fire({
                                    icon: 'success',
                                    title: 'OTP Sent Successfully!',
                                    text: response.message, // Use the message from the backend
                                    showConfirmButton: false,
                                    timer: 2000 // Auto close after 2 seconds
                                });
                            } else {
                                $('#email-error').text(response.message); // Display error message
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            $('#email-error').text('An error occurred. Please try again.');
                        }
                    });
                });

                // Form validation before submit
                $('#formAuthentication').submit(function(e) {
                    var isValid = true;

                    // Username validation
                    var username = $('#username').val();
                    if (!username) {
                        $('#username').addClass('is-invalid');
                        isValid = false;
                    } else {
                        $('#username').removeClass('is-invalid');
                    }

                    // Email validation (You might want to use a regex for more robust validation)
                    var email = $('#email').val();
                    if (!email) {
                        $('#email').addClass('is-invalid');
                        isValid = false;
                    } else {
                        $('#email').removeClass('is-invalid');
                    }

                    // OTP Validation
                    var otp = $('#otp').val();
                    if (!otp) {
                        $('#otp').addClass('is-invalid');
                        isValid = false;
                    } else {
                        $('#otp').removeClass('is-invalid');
                    }

                    // Password validation
                    var password = $('#password').val();
                    if (!password) {
                        $('#password').addClass('is-invalid');
                        isValid = false;
                    } else {
                        $('#password').removeClass('is-invalid');
                    }

                    // Terms validation
                    if (!$('#terms-conditions').is(':checked')) {
                        $('#terms-conditions').addClass('is-invalid');
                        isValid = false;
                    } else {
                        $('#terms-conditions').removeClass('is-invalid');
                    }

                    if (!isValid) {
                        e.preventDefault(); // Prevent form submission if validation fails
                    }
                });
            });



            $(document).ready(function() {
            const otpInput = $('#otp');
            const verifyBtn = $('#verifyBtn');
            const otpForm = $('#otpForm');

            // Initialize Toastr options
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right"
            };

            function validateOTP() {
                const otpValue = otpInput.val().trim();
                const isValidOTP = /^\d{6}$/.test(otpValue);
                verifyBtn.prop('disabled', !isValidOTP);
            }

            otpInput.on('input', validateOTP);
            validateOTP();

            otpForm.on('submit', function(e) {
                const otpValue = otpInput.val().trim();
                if (!/^\d{6}$/.test(otpValue)) {
                    e.preventDefault();
                    toastr.error("Please enter a valid 6-digit OTP.");
                }
            });
        });

        </script>
    @endpush
@endsection
