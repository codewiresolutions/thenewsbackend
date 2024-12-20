<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(); // Allow null values
            // OR

             // Make sure this field exists
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->string('otp')->nullable();
            $table->timestamps();
        });

    }

    public function down()
    {
        Schema::dropIfExists('users');
    }

};
