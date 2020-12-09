<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Util\Formatter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrdersController extends Controller
{
	public function show()
	{
		return view('orders.show');
	}

    public function create(Client $client)
    {
    	return view('orders.create', [
    		'client' => $client
    	]);
    }	

    public function store(Client $client, Request $request)
    {
        $this->validator(
            $data = $this->getFormattedData($request->all())
        );

        $order = $client->orders()
            ->create(
                \Arr::except($data, ['payment_type', 'installments'])
            );

        if ($data['payment_type'] == 'in_installment') {
            $order->installments()->createMany($data['installments']);
            $order->price = $order->installments()->sum('value');
            $order->save();
        }

        return response()->json([
            'message' => 'success',
            'redirect' => route('clients.show', $client)
        ]);
    }

    public function patch(Client $client, Order $order, Request $request)
    {
        
    }

    public function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'max:255'],
            'date' => ['required', 'date'],
            'installments.*.value' => ['required'],
            'installments.*.due_date' => ['required', 'date']
        ])->validate();
    }

    public function getFormattedData(array $data)
    {
        return Formatter::getFormatted([
            'name' => 'name',
            'installments.value|price' => 'money',
            'installments.due_date|date' => 'date'
        ], $data);
    }
}
