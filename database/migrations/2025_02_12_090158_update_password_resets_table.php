<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePasswordResetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('password_resets', function (Blueprint $table) {
            $table->dropColumn('token');
            $table->string('otp')->nullable()->after('email'); // Store OTP here
            $table->timestamp('otp_expires_at')->nullable()->after('otp'); // When OTP expires
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('password_resets', function (Blueprint $table) {
            $table->string('token');
            $table->dropColumn('otp');
            $table->dropColumn('otp_expires_at');
        });
    }
}

