<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Util\Formatter;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers {
        register as laravelRegister;
    }

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $this->validator(
            $data = $this->getFormattedData($request->all())
        )->validate();

        $data = \Helper::replaceKey($data, $data['account_type'], 'cpf_cnpj');
        $data['password'] = bcrypt($data['password']);

        event(new Registered($user = User::create($data)));

        $this->guard()->login($user);

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return response()->json([
            'message' => 'success',
            'redirect' => $this->redirectPath()
        ], 200);
    }

    private function getFormattedData(array $data) 
    {
        return Formatter::getFormatted([
            'cpf|cnpj|phone' => 'removeNonDigits',
            'fullname|trade_name|company_name' => 'name',
            'date_of_birth' => 'date'
        ], $data);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'account_type' => ['required', Rule::in(['cpf', 'cnpj'])],
            'fullname' => ['required', 'string', 'max:255', "regex:/^[\p{L}'][ \p{L}'-]*[\p{L}]$/u", 'min:3'],
            'cpf' => ['required_if:account_type,cpf', 'cpf', 'unique:users,cpf_cnpj'],
            'cnpj' => ['required_if:account_type,cnpj', 'cnpj', 'unique:users,cpf_cnpj'],
            'trade_name' => ['required_if:account_type,cnpj', 'max:255'],
            'company_name' => ['required_if:account_type,cnpj', 'max:255'],
            'phone' => ['required'],
            'date_of_birth' => ['required', 'date'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }
}
