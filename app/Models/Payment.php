<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['value', 'note', 'date'];

    public function order()
    {
    	return $this->belongsTo(Order::class);
    }

    public function installment()
    {
    	return $this->belongsTo(Installment::class);
    }
}
