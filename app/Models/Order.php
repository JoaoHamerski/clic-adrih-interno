<?php

namespace App\Models;

use App\Traits\HasSyncRelation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory, HasSyncRelation;

    protected $fillable = ['name', 'price', 'paid_at', 'date'];

    public function client()
    {
    	return $this->belongsTo(Client::class);
    }

    public function installments()
    {
    	return $this->hasMany(Installment::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function path()
    {
        return route('orders.show', [
            'client' => $this->client,
            'order' => $this
        ]);
    }

    public function hasInstallments()
    {
        return ! $this->installments->isEmpty();
    }

    public function isInstallmentsValueSame()
    {
        return $this->installments->pluck('value')->unique()->count() == 1;
    }

    public function getTotalPaid()
    {
       return sprintf('%.2f', $this->payments()->sum('value'), 2);
    }
    public function getTotalOwing()
    {
        return sprintf('%.2f', $this->price) - $this->getTotalPaid();
    }

    public function isPaid()
    {
        return $this->getTotalPaid() >= sprintf('%.2f', $this->price);
    }
}
