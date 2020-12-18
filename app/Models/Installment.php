<?php

namespace App\Models;

use App\Traits\HasSyncRelation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    use HasFactory, HasSyncRelation;

    protected $fillable = ['value', 'due_date', 'paid_at', 'note'];

    public function order()
    {
    	return $this->belongsTo(Order::class);
    }

    public function payment()
    {
    	return $this->hasOne(Payment::class);
    }

    public function isExpired()
    {
        return (! $this->paid_at) && 
            \Carbon\Carbon::now()->subDays(1)
                ->greaterThan($this->due_date);
    }
}
