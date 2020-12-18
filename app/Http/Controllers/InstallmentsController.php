<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Order;
use App\Models\Installment;
use Illuminate\Http\Request;

class InstallmentsController extends Controller
{
    public static function pay(Client $client, Order $order, Installment $installment)
    {
    	$installment->paid_at = \Carbon\Carbon::now();
    	$installment->save();

    	$order->payments()->create([
    		'value' => $installment->value,
    		'installment_id' => $installment->id,
            'date' => \Carbon\Carbon::now()->toDateString(),
    		'note' => 'Pagamento de parcela com vencimento para ' . \Helper::date($installment->due_date, '%d/%m/%Y')
    	]);

    	return $installment;
    }
}
