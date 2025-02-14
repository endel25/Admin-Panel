<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class ResetPasswordController extends Controller
{
    public function showOtpForm(Request $request)
    {
        $email = $request->get('email');
        return view('content.authentications.auth-otp-verify', compact('email'));
    }

    public function resetPasswordWithOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|numeric',
            'password' => 'required|confirmed|min:8',
        ]);

        $passwordReset = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('otp', $request->otp)
            ->first();

        if (!$passwordReset) {
            return back()->withErrors(['otp' => 'Invalid OTP.']);
        }

        if (Carbon::parse($passwordReset->otp_expires_at)->isPast()) {
            DB::table('password_resets')
                ->where('email', $request->email)
                ->delete();
            return back()->withErrors(['otp' => 'OTP has expired. Please request a new one.']);
        }

        $admin = DB::table('admins')
            ->where('email', $request->email)
            ->first();

        if (!$admin) {
            return back()->withErrors(['email' => 'We can not find a admin with that e-mail address.']);
        }

        DB::table('admins')
            ->where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);

        DB::table('password_resets')
            ->where('email', $request->email)
            ->delete();

        return redirect('/auth/login-basic')->with('status', 'Your password has been reset!');
    }

  }
