<?php

namespace App;
use App\User;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'name', 'email', 'apellidos','dni','telefono1', 'telefono2', 'direccion', 'ciudad', 'pais', 'password', 'role_id', 'programa_novios'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function generateToken()
    {
        $this->token = str_random(60);
        $this->save();
        return $this->token;
    }

    public function roles()
    {
        return $this->hasOne(Role::class, 'id', 'role_id');
    }

    public function hasRole($check)
    {
        $roles = $this->roles ? $this->roles->toArray() : [];
        return in_array($check, $roles);
    }

    public function orders()
    {
       return $this->hasMany(Orden::class, 'user_id');
    }
}
