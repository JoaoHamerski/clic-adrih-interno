<?php

namespace App\Models;

use App\Traits\HasSyncRelation;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory, HasSlug, HasSyncRelation;

    protected $guarded = ['cpf', 'cnpj', 'person_type', 'phone'];
    
    /**
     * Um cliente tem muitos pagamentos de muitos pedidos
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function payments()
    {
        return $this->hasManyThrough(Payment::class, Order::class);
    }
    
    public function phones()
    {
        return $this->hasMany(Phone::class);
    }   

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Retorna o número de telefone principal do cliente
     *
     * @return string 
     **/
    public function getPhone()
    {
    	if ($phone = $this->phones()->where('is_main', 1)->first()->number ?? null) {
            return $phone;
        }

        return $this->phones()->first()->number ?? null;
    }

    /**
     * Retorna os números secundários cadastrados do cliente.
     *
     * @return 
     **/
    public function getSecondaryPhones()
    {
        return $this->phones()
            ->where('number', '!=', $this->getPhone())
            ->get()
            ->pluck('number');
    }

    public function getPersonType()
    {
        if ($this->cpf_cnpj == null)
            return null;

        return strlen($this->cpf_cnpj) == 11 ? 'cpf' : 'cnpj';
    }

    public function getTotalOwing()
    {
        return bcsub(
            sprintf('%.2f', $this->orders()->sum('price')), 
            sprintf('%.2f', $this->payments()->sum('value')), 
            2
        );
    }

    public function path()
    {
        return route('clients.show', $this);
    }
}
