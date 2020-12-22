<?php

namespace App\Http\Controllers;

use App\Mail\AccountValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class EmailController extends Controller
{
    public function sendVerificationEmail(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            \Helper::flash([
                'type' => 'info', 'message' => 'Seu e-mail já é verificado!'
            ]);
        } else {
    	   $request->user()->sendEmailVerificationNotification();

        	\Helper::flash([
        		'type' => 'success', 'message' => 'E-mail de verificação enviado'
        	]);
        }


    	return back();
    }

    public function verifyEmail(EmailVerificationRequest $request)
    {
        $request->fulfill();

        \Helper::flash([
            'type' => 'success', 'message' => 'Parabéns, sua conta foi verificada com sucesso!'
        ]);

        return redirect()->route('clients.index');
    }
}
