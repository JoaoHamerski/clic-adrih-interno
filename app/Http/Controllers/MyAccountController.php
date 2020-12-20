<?php

namespace App\Http\Controllers;

use App\Util\Formatter;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class MyAccountController extends Controller
{
    public function index()
    {
    	return view('my-account.index', [
    		'user' => \Auth::user()
    	]);
    }

    public function patch(Request $request)
    {
        $user = \Auth::user();

        $this->validator(
            $data = $this->getFormattedData($request->all())
        );

        $user->update([
            'fullname' => $data['fullname'],
            'email' => $data['email'],
            'password' => empty($data['password']) 
                ? $user->password 
                : bcrypt($data['password'])
        ]);

        if ($user->wasChanged()) {
            \Helper::flash([
                'type' => 'success', 'message' => 'Dados alterados com sucesso!'
            ]);
        }

        return response()->json([
            'redirect' => route('my-account.show')
        ], 200);
    }

    public function getData()
    {
    	return \Auth::user();
    }

    public function getFormattedData(array $data)
    {
        return Formatter::getFormatted([
            'fullname' => 'name'
        ], $data);
    }

    public function validator(array $data)
    {
        Validator::make($data, [
            'fullname' => ['required', 'min:6', 'max:255', 'name'],
            'email' => ['required', 'max:255', 'email', Rule::unique('users')->ignore(\Auth::user()->id)],
            'password' => ['nullable', 'confirmed']
        ])->validate();
    }
}
