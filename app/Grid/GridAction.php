<?php

namespace App\Grid;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;

/**
 * Class GridAction
 *
 * Representa una acción disponible en el Grid
 *
 * @package App\Grid
 */
class GridAction implements Arrayable
{
    /**
     * @var string Clave única de la acción
     */
    private string $key;

    /**
     * Constructor de GridAction
     *
     * @param string $label Etiqueta visible de la acción
     * @param string $icon Icono de la acción
     * @param string $url URL de la acción (puede contener placeholders como ;id;)
     */
    public function __construct(
        private string $label,
        private string $icon,
        private string $url,
    )
    {
        $this->key = Str::slug($this->label);
    }

    /**
     * Convierte la acción a array
     *
     * @return array{key: string, label: string, icon: string, url: string}
     */
    public function toArray(): array {
        return [
            'key' => $this->key,
            'label' => $this->label,
            'icon' => $this->icon,
            'url' => $this->url,
        ];
    }
}
