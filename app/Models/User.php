<?php

namespace App\Models;

use App\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
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
        'password'
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

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::updated(function ($user) {
            if ($user->wasChanged('email')) {
                $user->email_verified_at = null;
                $user->saveQuietly();
                $user->sendEmailVerificationNotification();
            }
        });
    }

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

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail);
    }
}
