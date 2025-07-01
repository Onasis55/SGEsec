<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Estudiante extends Model
{

    protected $fillable = [
        'inasistencias',
        'id_usuario'
    ];

    public function user():BelongsTo{
        return $this->belongsTo(User::class, 'id_usuario');
    }
}
