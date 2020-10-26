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
     * 
     */

    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'username', 
        'administrador', 
        'foto', 
        'perfil_id',
        'grupo_id',
        'inativo',
        'empresa_id'
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

    public function perfil()
    {
        return $this->hasOne('App\Models\Perfil','id','perfil_id');
    }


    public function grupo()
    {
        return $this->hasOne('App\Models\Grupo','id','grupo_id');
    }

    public function empresa()
    {
        return $this->hasOne('App\Models\Empresa','id','empresa_id');
    }
}
