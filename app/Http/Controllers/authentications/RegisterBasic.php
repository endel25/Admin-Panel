<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Mail;

class RegisterBasic extends Controller
{

public function store(Request $request){
  $validated = $request->validate([
    'username' => 'required|string|max:255',
    'password' => 'required|string|min:6',
    'email' => 'required|email|unique:admins,email',
]);

// Check if validation passed
if (!$validated) {
    // You can return a response or redirect if validation fails
    return back()->withErrors($validated)->withInput();
}

// Create and save the admin
$admin = new Admin();
$admin->username = $validated['username'];
$admin->password = bcrypt($validated['password']); // Always hash passwords before saving
$admin->email = $validated['email'];
$admin->save();

// dd($admin);
$email=$admin->email;
$to=$email;
$msg="Thank you for registration";
$subject="Registration";
Mail::to($to)->send(new \App\Mail\WelcomeMail($msg,$subject));

return redirect()->route('auth-login-basic')->with('success', 'Registration successful. Please log in.');


}

public function index()
{
    return view('content.authentications.auth-register-basic');
}

// public function sendmail(){

// }
}
