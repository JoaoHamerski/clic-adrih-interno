<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    /**
     * Redireciona o usuário para a rota especificada,
     * replicando as mensagens flash caso existam.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        session()->reflash();

        return redirect()->route('clients.index');
    }
}
