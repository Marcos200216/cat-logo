<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\Subcategoria;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductoController extends Controller
{
    public function index()
    {
        $canal = session('admin_canal', 'normal');

        $productos = Producto::with('subcategoria.categoria', 'imagenes')
            ->whereHas('subcategoria.categoria', fn($q) => $q->where('canal', $canal))
            ->latest()
            ->get();

        $subcategorias = Subcategoria::with('categoria')
            ->whereHas('categoria', fn($q) => $q->where('canal', $canal))
            ->orderBy('categoria_id')
            ->orderBy('orden')
            ->get();

        return view('admin.productos.index', compact('productos', 'subcategorias'));
    }

    public function store(Request $request)
    {
        $canal = session('admin_canal', 'normal');

        $datos = $request->validate([
            'subcategoria_id' => [
                'required',
                Rule::exists('subcategorias', 'id')->whereIn(
                    'categoria_id',
                    \App\Models\Categoria::where('canal', $canal)->pluck('id')
                ),
            ],
            'nombre' => ['required', 'string', 'max:150'],
            'descripcion' => ['nullable', 'string'],
            'destacado' => ['nullable', 'boolean'],
            'activo' => ['nullable', 'boolean'],
            'tiene_color' => ['nullable', 'boolean'],
        ]);

        $datos['slug'] = Str::slug($datos['nombre']) . '-' . Str::random(5);
        $datos['destacado'] = $request->boolean('destacado');
        $datos['activo'] = $request->boolean('activo');
        $datos['tiene_color'] = $request->boolean('tiene_color');

        $producto = Producto::create($datos);

        return response()->json([
            'mensaje' => 'Producto creado. Ahora agrega sus imágenes y variantes.',
            'id' => $producto->id,
        ]);
    }

    public function show(Producto $producto)
    {
        $canal = session('admin_canal', 'normal');

        $producto->load('imagenes', 'variantes', 'subcategoria.categoria');
        $subcategorias = Subcategoria::with('categoria')
            ->whereHas('categoria', fn($q) => $q->where('canal', $canal))
            ->orderBy('categoria_id')
            ->orderBy('orden')
            ->get();

        $variantesPorTalla = $producto->variantes->groupBy(fn($v) => $v->talla ?? '');

        return view('admin.productos.show', compact('producto', 'subcategorias', 'canal', 'variantesPorTalla'));
    }

    public function update(Request $request, Producto $producto)
    {
        $canal = session('admin_canal', 'normal');

        $datos = $request->validate([
            'subcategoria_id' => [
                'required',
                Rule::exists('subcategorias', 'id')->whereIn(
                    'categoria_id',
                    \App\Models\Categoria::where('canal', $canal)->pluck('id')
                ),
            ],
            'nombre' => ['required', 'string', 'max:150'],
            'descripcion' => ['nullable', 'string'],
            'destacado' => ['nullable', 'boolean'],
            'activo' => ['nullable', 'boolean'],
            'tiene_color' => ['nullable', 'boolean'],
        ]);

        $datos['destacado'] = $request->boolean('destacado');
        $datos['activo'] = $request->boolean('activo');
        $datos['tiene_color'] = $request->boolean('tiene_color');

        $producto->update($datos);

        return response()->json(['mensaje' => 'Producto actualizado correctamente.']);
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();
        return response()->json(['mensaje' => 'Producto eliminado.']);
    }
}
