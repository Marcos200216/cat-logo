<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PanelProductoController extends Controller
{
    public function categorias(Request $request)
    {
        $canal = $request->query('canal', 'mayorista');

        $subcategorias = \App\Models\Subcategoria::with('categoria')
            ->whereHas('categoria', fn($q) => $q->where('canal', $canal))
            ->orderBy('categoria_id')
            ->orderBy('orden')
            ->get();

        $resultado = $subcategorias->map(function ($sub) {
            return [
                'categoria' => $sub->categoria->nombre,
                'subcategoria_id' => $sub->id,
                'subcategoria' => $sub->nombre,
            ];
        });

        return response()->json($resultado);
    }

    public function store(Request $request)
    {
        $canal = $request->input('canal', 'mayorista');

        $datos = $request->validate([
            'subcategoria_id' => [
                'required',
                Rule::exists('subcategorias', 'id')->whereIn(
                    'categoria_id',
                    Categoria::where('canal', $canal)->pluck('id')
                ),
            ],
            'nombre' => ['required', 'string', 'max:150'],
            'descripcion' => ['nullable', 'string'],
            'tiene_color' => ['nullable', 'boolean'],
        ]);

        $datos['slug'] = Str::slug($datos['nombre']) . '-' . Str::random(5);
        $datos['destacado'] = false;
        $datos['activo'] = true;
        // En el canal normal todavía no se manejan colores: siempre queda apagado.
        $datos['tiene_color'] = $canal === 'normal' ? false : $request->boolean('tiene_color');

        $producto = Producto::create($datos);

        return response()->json(['id' => $producto->id]);
    }

    public function subirImagen(Request $request, Producto $producto)
    {
        $request->validate([
            'imagen' => ['required', 'image', 'max:4096'],
        ]);

        $ordenActual = $producto->imagenes()->max('orden') ?? -1;

        $img = $producto->imagenes()->create([
            'ruta' => $request->file('imagen')->store('productos', 'public'),
            'orden' => $ordenActual + 1,
        ]);

        return response()->json([
            'id' => $img->id,
            'url' => asset('storage/' . $img->ruta),
        ]);
    }

    public function variantes(Request $request, Producto $producto)
    {
        $datos = $request->validate([
            'talla' => ['required', 'string', 'max:20'],
            'stock' => ['required', 'integer', 'min:0'],
        ]);

        $variante = $producto->variantes()->create([
            'talla' => $datos['talla'],
            'color' => null,
            'stock' => $datos['stock'],
        ]);

        return response()->json(['id' => $variante->id]);
    }
}