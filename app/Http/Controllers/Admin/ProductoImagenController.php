<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\ProductoImagen;
use Illuminate\Http\Request;

class ProductoImagenController extends Controller
{
        public function store(Request $request, Producto $producto)
    {
        $request->validate([
            'imagenes' => ['required', 'array'],
            'imagenes.*' => ['image', 'max:2048'],
        ]);

        $ordenActual = $producto->imagenes()->max('orden') ?? -1;
        $nuevas = [];

        foreach ($request->file('imagenes') as $archivo) {
            $ordenActual++;
            $img = $producto->imagenes()->create([
                'ruta' => $archivo->store('productos', 'public'),
                'orden' => $ordenActual,
            ]);

            $nuevas[] = [
                'id' => $img->id,
                'url' => asset('storage/' . $img->ruta),
                'color' => $img->color,
            ];
        }

        return response()->json([
            'mensaje' => 'Imágenes agregadas correctamente.',
            'imagenes' => $nuevas,
        ]);
    }

    public function destroy(Producto $producto, ProductoImagen $imagen)
    {
        $imagen->delete();
        return response()->json(['mensaje' => 'Imagen eliminada.']);
    }

    public function update(Request $request, Producto $producto, ProductoImagen $imagen)
{
    $datos = $request->validate([
        'color' => ['nullable', 'string', 'max:50'],
    ]);

    $imagen->update($datos);

    return response()->json(['mensaje' => 'Color actualizado.']);
}
    
}