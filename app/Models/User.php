<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fullname',
        'email',
        'password',
        'cpf_cnpj',
        'phone',
        'date_of_birth',
        'trade_name',
        'company_name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function firstName()
    {
        return explode(' ', $this->fullname)[0];
    }

    /**
     * Um usuário pertence a uma regra
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Verifica se o usuário possui determinada regra
     * 
     * @param int | array $role
     * @return boolean
     */
    public function hasRole($role)
    {
        if (is_array($role)) {
            foreach($role as $r) {
                if ($this->role()->where('name', $r)->exists())
                    return true;
            }
        }

        return $this->role()->where('name', $role)->exists();
    }
}
