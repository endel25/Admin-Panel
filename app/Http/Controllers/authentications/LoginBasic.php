<?php

namespace App\Http\Controllers\authentications;
use App\Models\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class LoginBasic extends Controller
{
  public function fetch(Request $request) {
    $validate = $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:6',
    ]);

    $user = Admin::where('email', $validate['email'])->first();

    if ($user) {
        if (Hash::check($validate['password'], $user->password)) {
            // Manually log in the user
            auth()->login($user);

            // Redirect to the dashboard
            return redirect()->route('dashboard-analytics');
        } else {
            return back()->withErrors(['password' => 'Invalid credentials.']);
        }
    } else {
        return back()->withErrors(['email' => 'No account found with that email.']);
    }
}

  public function index()
  {
    return view('content.authentications.auth-login-basic');
  }
}
