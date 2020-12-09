<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory, HasSlug;

    protected $guarded = ['cpf', 'cnpj', 'person_type', 'phone'];
    
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

    public function getPhone()
    {
    	if ($phone = $this->phones()->where('is_main', 1)->first()->number ?? null) {
            return $phone;
        }

        return $this->phones()->first()->number ?? null;
    }

    public function getPersonType()
    {
        if ($this->cpf_cnpj == null)
            return null;

        return strlen($this->cpf_cnpj) == 11 ? 'cpf' : 'cnpj';
    }

public function updatePhones(array $requestPhones)
{
    $phoneIds = $this->phones->pluck('id')->toArray();
    $requestPhoneIds = [];

    foreach ($requestPhones as $requestPhone) {
        if (isset($requestPhone['id']) && in_array($requestPhone['id'], $phoneIds)) {
            $requestPhoneIds[] = $requestPhone['id'];

            $this->phones()
                ->where('id', $requestPhone['id'])
                ->update(\Arr::except($requestPhone, ['created_at', 'updated_at']));
        } else {
            $this->phones()
                ->create(\Arr::except($requestPhone, ['created_at', 'updated_at']));
        }
    }

    if (! empty($idsToDelete = array_diff($phoneIds, $requestPhoneIds))) {
        $this->phones()->whereIn('id', $idsToDelete)->delete();
    }
}

    public function path()
    {
        return route('clients.show', $this);
    }

    public function phones()
    {
    	return $this->hasMany(Phone::class);
    }	

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
