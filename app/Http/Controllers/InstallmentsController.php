<?php

namespace App\Http\Controllers;

use App\Util\Formatter;
use App\Models\Client;
use App\Models\Order;
use App\Models\Installment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InstallmentsController extends Controller
{
    public function pay(Client $client, Order $order, Installment $installment)
    {
    	$installment->paid_at = \Carbon\Carbon::now();
    	$installment->save();

    	$order->payments()->create([
    		'value' => $installment->total_remaining,
    		'installment_id' => $installment->id,
            'date' => \Carbon\Carbon::now()->toDateString(),
    		'note' => 'Pagamento de parcela com vencimento para ' . \Helper::date($installment->due_date, '%d/%m/%Y')
    	]);

    	return $installment;
    }

    public function payParcial(Client $client, Order $order, Installment $installment, Request $request)
    {
        $this->validator(
            $data = $this->getFormattedData($request->all()),
            $installment->total_remaining
        );

        $order->payments()->create([
            'value' => $data['value'],
            'installment_id' => $installment->id,
            'date' => \Carbon\Carbon::now()->toDateString(),
            'note' => 'Pagamento parcial da parcela com vencimento para ' . \Helper::date($installment->due_date, '%d/%m/%Y')
       ]);

        if ($installment->total_remaining == 0) {
            $installment->paid_at = \Carbon\Carbon::now();
            $installment->save();
        }

        return Installment::with('payments')->find($installment->id);
    }

    public function validator(array $data, $maxValue = null)
    {
        return Validator::make($data, [
            'value' => [
                'required', 
                'numeric', 
                $maxValue ? 'max:' . sprintf('%.2f', $maxValue) : ''
            ] 
        ], [
            'value.max' => 'O pagamento da parcela não pode ser maior que o restante a ser pago (' . \Mask::money($maxValue) . ')'
            ])->validate();
    }

    public function getFormattedData(array $data)
    {
        return Formatter::getFormatted([
            'value' => 'sanitizeBRL'
        ], $data);
    }
}
