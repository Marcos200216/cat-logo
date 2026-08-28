<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Producto extends Model
{
    protected $fillable = [
        'subcategoria_id',
        'nombre',
        'slug',
        'descripcion',
        'destacado',
        'activo',
        'tiene_color',
    ];

    protected $casts = [
        'destacado' => 'boolean',
        'activo' => 'boolean',
        'tiene_color' => 'boolean',
    ];

    public function subcategoria(): BelongsTo
    {
        return $this->belongsTo(Subcategoria::class);
    }

    public function variantes(): HasMany
    {
        return $this->hasMany(ProductoVariante::class);
    }

    public function imagenes(): HasMany
    {
        return $this->hasMany(ProductoImagen::class)->orderBy('orden');
    }

    public function imagenPrincipal(): ?ProductoImagen
    {
        return $this->imagenes()->first();
    }

    public function tieneVariantes(): bool
    {
        return $this->variantes()->exists();
    }

    public function coloresConImagen(): array
{
    return $this->imagenes
        ->whereNotNull('color')
        ->unique('color')
        ->values()
        ->map(fn ($img) => [
            'color' => $img->color,
            'imagen' => $img->ruta,
        ])
        ->toArray();
}

}