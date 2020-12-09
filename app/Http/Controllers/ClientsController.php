<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Util\Formatter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ClientsController extends Controller
{
    public function index()
    {
    	return view('clients.index', [
            'clients' => Client::latest()->get()
        ]);
    }

    public function store(Request $request)
    {
    	$this->validator(
            $data = $this->getFormattedData($request->all())
        );

        $data['cpf_cnpj'] = $data[$data['person_type']];

        $client = Client::create($data);

        $client->phones()->createMany(collect($data['phone'])->where('number', '!=', ''));

        return response()->json([
            'message' => 'success',
            'redirect' => route('clients.index')
        ], 200);
    }   

    public function show(Client $client)
    {
        return view('clients.show', compact('client'));
    }

    public function patch(Client $client, Request $request)
    {
        $this->validator(
            $data = $this->getFormattedData($request->all()),
            $client
        );

        $data['cpf_cnpj'] = $data[$data['person_type']];

        $client->update($data);
        $client->updatePhones(collect($data['phone'])->where('number', '!=', '')->toArray());

        return response()->json([
            'message' => 'success',
            'redirect' => route('clients.show', $client)
        ]);
    }

    public function getClient(Client $client)
    {
        return response()->json([
            'form' => [
                'person_type' => $client->getPersonType() ?? 'cpf',
                'name' => $client->name,
                'cpf' => $client->getPersonType() == 'cpf' ? $client->cpf_cnpj : '' ,
                'cnpj' => $client->getPersonType() == 'cnpj' ? $client->cpf_cnpj : '',
                'phone' => $client->phones->toArray(),
                'city' => $client->city,
                'address' => $client->address
            ]
        ], 200);
    }

    public function getFormattedData(array $data)
    {
        return Formatter::getFormatted([
            'name|address|city' => 'name',
            'phone.number|cpf|cnpj' => 'stripNonDigits'
        ], $data);
    }

    public function validator(array $data, $client = null)
    {
        return Validator::make($data, [
            'person_type' => ['nullable', Rule::in(['cpf', 'cnpj'])],
            'name' => ['required', 'string', 'max:255', 'name'],
            'rg' => ['nullable', 'string', 'max:20'],
            'cpf' => [
                'nullable', 
                $data['person_type'] == 'cpf' ? 'cpf' : '',
                Rule::unique('clients', 'cpf_cnpj')->ignore($client->id ?? '')
            ],
            'cnpj' => ['nullable', $data['person_type'] == 'cnpj' ? 'cnpj' : ''],
            'city' => ['nullable', 'string', 'max:255'],
            'phone.*.number' => ['nullable', 'string', 'min:8'],
            'address' => ['nullable', 'string', 'max:255']
        ])->validate();
    }
}
