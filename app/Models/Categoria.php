<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Categoria extends Model
{
    protected $fillable = [
        'nombre',
        'slug',
        'imagen',
        'orden',
        'activo',
        'canal',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'orden' => 'integer',
    ];

    public function subcategorias(): HasMany
    {
        return $this->hasMany(Subcategoria::class);
    }

    public function productos(): HasManyThrough
    {
        return $this->hasManyThrough(Producto::class, Subcategoria::class);
    }
}