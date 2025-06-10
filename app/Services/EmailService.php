<?php
namespace App\Services;

use Illuminate\Support\Facades\Mail;
use App\Mail\GenericMail;

class EmailService
{
    public function sendEmail($to, $subject, $body)
    {
        Mail::to($to)->send(new GenericMail($subject, $body));
    }
}
