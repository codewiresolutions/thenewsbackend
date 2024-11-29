<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Mail\Message;
use Carbon\Carbon;

class PasswordResetController extends Controller
{
    // Send the reset password email with OTP
    public function send_reset_password_email(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->email;

        // Check if the user's email exists
        $user = User::where('email', $email)->first();
        if (!$user) {
            return response([
                'message' => 'Email does not exist',
                'status' => 'failed'
            ], 404);
        }

        // Generate a 4-digit numeric OTP code
        $code = random_int(1000, 9999);

        // Save the OTP to the PasswordReset table
        User::updateOrCreate(
            ['email' => $email], // Update if email exists, otherwise create
            [
                'email' => $email,
                'otp' => $code, // Save the 4-digit code as the "OTP"
                'created_at' => Carbon::now(),
            ]
        );

        // Send the OTP via email
        Mail::send('reset', ['code' => $code], function (Message $message) use ($email) {
            $message->subject('Reset Your Password');
            $message->to($email);
        });

        return response([
            'message' => 'Password reset code sent. Check your email.',
            'status' => 'success'
        ], 200);
    }

    // Reset the password using OTP from the URL and data from the body
    public function reset(Request $request, $otp)
    {
        // Validate the email and password in the body
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);

        $email = $request->email;
        $password = $request->password;

        // Delete codes older than 20 minutes to prevent re-use
        $expirationTime = Carbon::now()->subMinutes(20);
        PasswordReset::where('created_at', '<=', $expirationTime)->delete();

        // Find the reset record by email and OTP (using OTP from URL)
        $passwordReset = PasswordReset::where('email', $email)
            ->where('otp', $otp) // Only use the OTP from the URL
            ->first();

        if (!$passwordReset) {
            return response([
                'message' => 'Invalid or expired reset code',
                'status' => 'failed'
            ], 404);
        }

        // Reset the user's password
        $user = User::where('email', $email)->first();
        if ($user) {
            $user->password = Hash::make($password);
            $user->save();

            // Delete the password reset record
            PasswordReset::where('email', $email)->delete();

            return response([
                'message' => 'Password reset successfully',
                'status' => 'success'
            ], 200);
        }

        return response([
            'message' => 'User not found',
            'status' => 'failed'
        ], 404);
    }
}
