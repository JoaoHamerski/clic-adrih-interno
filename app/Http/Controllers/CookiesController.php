<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CookiesController extends Controller
{
	public function getCookie($name)
	{
		return \Cookie::get($name);
	}
	/**
	 * Seta um cookie longo tempo (5 anos)
	 * 
	 * @param Illuminate\Http\Request $request
	 *
	 * @return void
	 **/
    public function setCookie(Request $request)
	{
		\Cookie::queue(\Cookie::forever($request->name, $request->value));
	}

	/**
	 * Deleta um cookie pelo nome passado
	 * 
	 * @param Illuminate\Http\Request $request
	 *
	 * @return void
	 **/
	public function deleteCookie(Request $request)
	{
		\Cookie::queue(\Cookie::forget($request->name));
	}
}
