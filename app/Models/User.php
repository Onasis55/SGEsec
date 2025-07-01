<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'cuenta',
        'name',
        'apellido_paterno',
        'apellido_materno',
        'curp',
        'password',
        'rol_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function rol():BelongsTo{
        return $this->belongsTo(Rol::class, 'rol_id');
    }

    public function estudiante():HasOne
    {
        return $this->hasOne(Estudiante::class, 'id_usuario');
    }
}
