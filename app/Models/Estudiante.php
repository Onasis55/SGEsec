<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    protected $fillable = [
        'inasistencias',
        'id_usuario'
    ];
}
