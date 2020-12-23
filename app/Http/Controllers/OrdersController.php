<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Order;
use App\Util\Formatter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;

class OrdersController extends Controller
{
    public function index(Request $request)
    {
        $orders = $this->getRequestedQuery($request);

        return view('orders.index', [
            'orders' => $orders->latest()->paginate(10)
        ]);
    }

	public function show(Client $client, Order $order)
	{
		return view('orders.show', compact('client', 'order'));
	}

    public function create(Client $client)
    {
    	return view('orders.create', [
    		'client' => $client
    	]);
    }	

    public function edit(Client $client, Order $order)
    {
        return view('orders.edit', compact('order'));
    }

    public function store(Client $client, Request $request)
    {
        $this->validator(
            $data = $this->getFormattedData($request->all())
        );

        $order = $client->orders()->create($data);

        if ($data['payment_type'] == 'in_installment') {
            $order->installments()->createMany($data['installments']);
        }

        \Helper::flash([
            'type' => 'success', 'message' => 'Pedido criado com sucesso!'
        ]);

        return response()->json([
            'message' => 'success',
            'redirect' => route('orders.show', [$client, $order])
        ]);
    }

    public function patch(Client $client, Order $order, Request $request)
    {
        $this->validator(
            $data = $this->getFormattedData($request->all()),
            $order
        );

        $order->update($data);

        if ($data['payment_type'] == 'in_installment') {
            $order->sync($data['installments'], 'installments');
            $order->price = $order->installments()->sum('value');
            $order->save();
        }

        \Helper::flash([
            'type' => 'success', 'message' => 'Pedido atualizado com sucesso!'
        ]);

        return response()->json([
            'message' => 'success',
            'redirect' => route('orders.show', [
                'order' => $order,
                'client' => $order->client
            ]) 
        ], 200);
    }

    public function destroy(Client $client, Order $order)
    {
        $order->delete();

        \Helper::flash([
            'type' => 'success', 'message' => 'Pedido deletado com sucesso!'
        ]);

        return response()->json([
            'message' => 'success',
            'redirect' => route('clients.show', $client)
        ], 200);
    }

    public function getRequestedQuery($request)
    {
        $orders = Order::query();

        if ($request->filled('nome')) {
            $orders->whereHas('client', function(Builder $query) use ($request) {
                $query->where('name', 'like', '%' . $request->nome . '%');
            });
        }

        return $orders;
    }

    public function getOrder(Client $client, Order $order)
    {       
        return $client->orders()
            ->with('installments')
            ->find($order->id);
    }

    public function getOrderDetailsView(Client $client, Order $order)
    {
        return view('orders.partials.all', [
            'client' => $client,
            'order' => $order
        ])->render();
    }

    public function getOrdersCardView(Client $client)
    {
        return view('clients._orders-card', [
            'orders' => $client->orders()
                ->latest()
                ->paginate(3)
        ])->render();
    }

    public function validator(array $data, $order = null)
    {
        return Validator::make($data, [
            'price' => [
                'required', 
                'numeric', 
                'min:' . ($order ? $order->getTotalPaid() : 0.01)
            ],
            'name' => ['required', 'max:255'],
            'date' => ['required', 'date'],
            'installments.*.value' => ['required'],
            'installments.*.due_date' => ['required', 'date']
        ], [
            'price.min' => ($order 
                ? 'O preço mínimo não pode ser menor que o total já pago (' .  \Mask::money($order->getTotalPaid()) . ')'
                : 'Informe um preço maior que R$0,00')
        ])->validate();
    }

    public function getFormattedData(array $data)
    {
        return Formatter::getFormatted([
            'name' => 'stripMultipleWhitespaces',
            'installments.value|price' => 'sanitizeBRL',
            'installments.due_date|date' => 'date'
        ], $data);
    }
}
