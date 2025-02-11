<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;

class TwoFactorController extends Controller
{
    public function show()
    {
        return view('content.authentications.auth-two-factor');
    }

    public function verify(Request $request)
    {
        $request->validate(['otp' => 'required']);

        $user = Auth::user();

        if ($user->two_factor_code === $request->otp && now()->lt($user->two_factor_expires_at)) {
            $user->resetTwoFactorCode();
            return redirect()->route('dashboard');
        }

        return back()->withErrors(['otp' => 'Invalid or expired OTP.']);
    }
}
