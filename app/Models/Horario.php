<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Asegúrate de tener esto si usas BelongsTo

class Horario extends Model
{
    protected $fillable = [
        'materia_id',
        // 'hora_ini', // Eliminado
        // 'hora_fin'  // Eliminado
    ];

    public function grupos(): HasMany
    {
        return $this->hasMany(Grupo::class, 'horario_id');
    }

    public function materia(): BelongsTo
    {
        return $this->belongsTo(Materia::class, 'materia_id');
    }
}
