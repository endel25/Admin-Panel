<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Mail;
use App\Mail\TwoFactorMail;
use Illuminate\Support\Facades\Hash;  // Import Hash facade
use Illuminate\Support\Str;  // Import Str class for random string generation
use Illuminate\Support\Facades\Cache; // Import the Cache facade

class RegisterBasic extends Controller
{

    public function index()
    {
        return view('content.authentications.auth-register-basic');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $email = $request->email;
        $otp = mt_rand(100000, 999999); // Generate a 6-digit OTP
        $now = now();
        $expiresAt = $now->addMinutes(10);

        // Store the OTP in the cache with an expiration time (e.g., 10 minutes)
        Cache::put('otp_' . $email, ['code' => $otp, 'expires_at' => $expiresAt], 600); // 600 seconds = 10 minutes

        // Send the OTP via email
        Mail::to($email)->send(new TwoFactorMail($otp));

        return response()->json(['success' => true, 'message' => 'OTP sent successfully!']);
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'username' => 'required|string|max:255',
        'password' => 'required|string|min:6',
        'email' => 'required|email|unique:admins,email',
        'otp' => 'required|string|size:6', // Ensure OTP is present and 6 digits long
    ]);

    $email = $validated['email'];
    $otp = $validated['otp'];

    // Retrieve the stored OTP from the cache
    $storedOtpData = Cache::get('otp_' . $email);

    if (!$storedOtpData) {
        return back()->withErrors(['otp' => 'OTP not found or expired.'])->withInput();
    }

    if ($otp != $storedOtpData['code']) {
        return back()->withErrors(['otp' => 'Invalid OTP.'])->withInput();
    }

    if (now()->gt($storedOtpData['expires_at'])) {
        return back()->withErrors(['otp' => 'OTP has expired.'])->withInput();
    }

    // Create and save the admin
    $admin = new Admin();
    $admin->username = $validated['username'];
    $admin->password = bcrypt($validated['password']); // Always hash passwords before saving
    $admin->email = $validated['email'];
    $admin->save();

    // Clear the OTP from the cache
    Cache::forget('otp_' . $email);

    $msg = "Thank you for registration";
    $subject = "Registration";
    Mail::to($email)->send(new \App\Mail\WelcomeMail($msg, $subject));

    // Use session flash to pass the success message
    return redirect()->route('auth-login-basic')->with('success', 'Registration successful!');
}

}
