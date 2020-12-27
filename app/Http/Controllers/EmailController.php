<?php

namespace App\Http\Controllers;

use App\Mail\AccountValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Notifications\Messages\MailMessage;

class EmailController extends Controller
{
    /**
     * Método de testes para pre-visualizar o template de emails criados
     **/
    public function preview()
    {
        return (new MailMessage)->markdown('emails.password-reset', ['url' => 'asd']);
    }
}
