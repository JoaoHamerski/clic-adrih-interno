<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Order;
use App\Util\Formatter;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
   	public function store(Client $client, Order $order, Request $request)
   	{
   		$this->validator(
   			$data = $this->getFormattedData($request->all()), 
            $order
   		);

   		$order->payments()->create($data);

   		return response()->json([
   			'message' => 'success',
   			'redirect' => route('orders.show', [
   				'order' => $order,
   				'client' => $client
   			])
   		], 200);
   	}

   	public function validator(array $data, $order = null)
   	{
   		return Validator::make($data, [
   			'value' => ['required', 'numeric', 'max:' . $order->getTotalOwing()],
   			'date' => ['required', 'date']
   		], [
            'value.max' => 'O valor de pagamento não pode ser maior que o restante a ser pago (' . \Mask::money($order->getTotalOwing()) . ')'
         ])->validate();
   	}

   	public function getFormattedData(array $data)
   	{
   		return Formatter::getFormatted([
   			'value' => 'sanitizeBRL',
   			'date' => 'date'
   		], $data);
   	}
}
