<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('content.authentications.auth-forgot-password-basic'); // Or your view path
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = DB::table('admins')->where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'We can not find a user with that e-mail address.']);
        }

        // Generate OTP
        $otp = mt_rand(100000, 999999); // Generate a 6-digit OTP

        // OTP Expiration (e.g., 10 minutes)
        $otpExpiresAt = Carbon::now()->addMinutes(10);

        // Delete any existing OTPs for this user
        DB::table('password_resets')->where('email', $request->email)->delete();

        // Store OTP in the password_resets table
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'otp' => $otp,
            'otp_expires_at' => $otpExpiresAt,
            'created_at' => Carbon::now()
        ]);

        // Send the OTP via email
        $this->sendOtpEmail($request->email, $otp);

        // Redirect to the OTP verification form
        return redirect()->route('password.reset.otp.form', ['email' => $request->email])
            ->with('status', 'We have sent an OTP to your email address.');
    }

    private function sendOtpEmail($email, $otp)
    {
        $user = DB::table('admins')->where('email', $email)->first();

        Mail::send('emails.password_reset_otp', ['otp' => $otp], function ($message) use ($email, $user) {
            $message->to($email);
            $message->subject('Your OTP for Password Reset');
        });
    }
}
