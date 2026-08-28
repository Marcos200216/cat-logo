<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\ProductoVariante;
use Illuminate\Http\Request;

class ProductoVarianteController extends Controller
{
    public function store(Request $request, Producto $producto)
    {
        $datos = $request->validate([
            'talla' => ['nullable', 'string', 'max:20'],
            'color' => ['nullable', 'string', 'max:50'],
            'stock' => ['required', 'integer', 'min:0'],
        ]);

        $variante = $producto->variantes()->create($datos);

        return response()->json(['mensaje' => 'Variante agregada.', 'variante' => $variante]);
    }

    public function update(Request $request, Producto $producto, ProductoVariante $variante)
{
    $datos = $request->validate([
        'talla' => ['sometimes', 'nullable', 'string', 'max:20'],
        'color' => ['sometimes', 'nullable', 'string', 'max:50'],
        'stock' => ['sometimes', 'required', 'integer', 'min:0'],
    ]);

    $variante->update($datos);

    return response()->json(['mensaje' => 'Variante actualizada.']);
}

    public function destroy(Producto $producto, ProductoVariante $variante)
    {
        $variante->delete();
        return response()->json(['mensaje' => 'Variante eliminada.']);
    }
}