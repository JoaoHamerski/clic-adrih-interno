<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails {
        verify as laravelVerify;
    }

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:3,1')->only('verify', 'send', 'resend');
    }

    /**
     * Envia o e-mail de confirmação para o e-mail do usuário
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse
     **/
    public function send(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            \Helper::flash([
                'type' => 'info', 'message' => 'Seu e-mail já é verificado!'
            ]);

            return back();
        }

       $request->user()->sendEmailVerificationNotification();

        \Helper::flash([
            'type' => 'success', 'message' => 'E-mail de verificação enviado'
        ]);

        return back();
    }

    /**
     * Marca o e-mail como verificado com sucesso.
     *
     * @param Illuminate\Foundation\Auth\EmailVerificationRequest $request
     *
     * @return Illuminate\Http\RedirectResponse
     **/
    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();

        \Helper::flash([
            'type' => 'success', 'message' => 'Parabéns, sua conta foi verificada com sucesso!'
        ]);

        return redirect()->route('clients.index');
    }
}
