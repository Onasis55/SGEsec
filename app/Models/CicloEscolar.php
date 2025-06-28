<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CicloEscolar extends Model
{
    protected $fillable = [
        'ciclo',
        'fecha_ini',
        'fecha_fin'
    ];
}
