<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username', 'email', 'password', 'two_factor_code', 'two_factor_expires_at'
    ];

    protected $hidden = [
        'password', 'remember_token', 'two_factor_code'
    ];

    public function generateTwoFactorCode() {
        $this->two_factor_code = rand(100000, 999999);
        $this->two_factor_expires_at = Carbon::now()->addMinutes(10);
        $this->save();
    }


    public function resetTwoFactorCode() {
        $this->two_factor_code = null;
        $this->two_factor_expires_at = null;
        $this->save();
    }
}
