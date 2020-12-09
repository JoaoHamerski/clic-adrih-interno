<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function hasInstallments()
    {
        return ! $this->installments->isEmpty();
    }

    public function isInstallmentsValueSame()
    {
        return $this->installments->pluck('value')->unique()->count() == 1;
    }

    public function client()
    {
    	return $this->belongsTo(Client::class);
    }

    public function installments()
    {
    	return $this->hasMany(Installment::class);
    }
}
