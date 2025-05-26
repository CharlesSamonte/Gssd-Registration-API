<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Mail;
use Illuminate\Http\Log;

use Illuminate\Support\Facades\Hash;

class EmailController extends Controller
{
    public function sendEmailAccessCode(Request $request)
    {
        try {
            $code = rand(100000, 999999); // Generate a random 6-digit code
            $hashedCode = \Hash::make($code); // Hash the code for security
            $email = $request->input('email');
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return response()->json(['error' => 'Invalid email address'], 400);
            }

            \Mail::raw('Your access code is: ' . $code, function ($message) use ($email) {
                $message->to($email)
                    ->subject('Access Code');
            });

            \Log::info("Access code sent to {$email}");

        } catch (\Exception $e) {
            \Log::error("Error sending access code: " . $e->getMessage());
            return response()->json(['error' => 'Failed to send access code'], 500);
        }
    }

}
