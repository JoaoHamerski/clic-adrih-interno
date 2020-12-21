<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('index');
    }

    public function show()
    {
    	return view('show');
    }

    public function store(Request $request)
    {
    	Mail::raw('Funcionou pra caralho', function($message) use ($request) {
    		$message->to('joaohamerski@hotmail.com')
    			->subject('Assunto aqui');
    	});

    	\Helper::flash([
    		'type' => 'success', 'message' => 'E-mail enviado com sucesso!'
    	]);

    	return redirect('email');
    }
}
