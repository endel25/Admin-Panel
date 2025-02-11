@extends('layouts.blankLayout')

@section('title', 'Two-Factor Authentication')

@section('content')
<div class="container">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-4">
            <div class="card p-3">
                <h4 class="mb-2">Two-Factor Authentication</h4>
                <p class="mb-4">Please enter the OTP sent to your email.</p>

                <form method="POST" action="{{ route('auth.two-factor.verify') }}">
                    @csrf
                    <div class="form-floating form-floating-outline mb-3">
                        <input type="text" class="form-control" id="otp" name="otp" placeholder="Enter OTP" required>
                        <label for="otp">Enter OTP</label>
                    </div>

                    <button class="btn btn-primary d-grid w-100" type="submit">Verify</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
