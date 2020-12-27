<?php

namespace App\Models;

use App\Traits\HasSyncRelation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    use HasFactory, HasSyncRelation;

    public $appends = ['total_remaining', 'total_paid'];
    protected $fillable = ['value', 'due_date', 'paid_at', 'note'];

    public function order()
    {
    	return $this->belongsTo(Order::class);
    }

    public function payments()
    {
    	return $this->hasMany(Payment::class);
    }

    public function getTotalPaidAttribute()
    {
        return $this->payments()->sum('value');
    }

    public function getTotalRemainingAttribute()
    {
        return bcsub($this->value, $this->total_paid, 4);
    }

    public function isExpired()
    {
        return (! $this->paid_at) && 
            \Carbon\Carbon::now()->subDays(1)
                ->greaterThan($this->due_date);
    }
}
