<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Subcategoria;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SubcategoriaController extends Controller
{
    public function index()
    {
        $canal = session('admin_canal', 'normal');

        $subcategorias = Subcategoria::with('categoria')
            ->whereHas('categoria', fn ($q) => $q->where('canal', $canal))
            ->orderBy('categoria_id')
            ->orderBy('orden')
            ->get();

        $categorias = Categoria::where('canal', $canal)->orderBy('orden')->get();

        return view('admin.subcategorias.index', compact('subcategorias', 'categorias'));
    }

    public function store(Request $request)
{
    $canal = session('admin_canal', 'normal');

    $datos = $request->validate([
        'categoria_id' => [
            'required',
            Rule::exists('categorias', 'id')->where('canal', $canal),
        ],
        'nombre' => ['required', 'string', 'max:100'],
        'activo' => ['nullable', 'boolean'],
    ]);

    $datos['slug'] = Str::slug($datos['nombre']);
    $datos['activo'] = $request->boolean('activo');
    $datos['orden'] = (int) (Subcategoria::where('categoria_id', $datos['categoria_id'])->max('orden') ?? -1) + 1;

    Subcategoria::create($datos);

    return response()->json(['mensaje' => 'Subcategoría creada correctamente.']);
}

public function update(Request $request, Subcategoria $subcategoria)
{
    $canal = session('admin_canal', 'normal');

    $datos = $request->validate([
        'categoria_id' => [
            'required',
            Rule::exists('categorias', 'id')->where('canal', $canal),
        ],
        'nombre' => ['required', 'string', 'max:100'],
        'activo' => ['nullable', 'boolean'],
    ]);

    $datos['slug'] = Str::slug($datos['nombre']);
    $datos['activo'] = $request->boolean('activo');

    // Si cambia de categoría, se manda al final de la nueva
    if ($datos['categoria_id'] != $subcategoria->categoria_id) {
        $datos['orden'] = (int) (Subcategoria::where('categoria_id', $datos['categoria_id'])->max('orden') ?? -1) + 1;
    }

    $subcategoria->update($datos);

    return response()->json(['mensaje' => 'Subcategoría actualizada correctamente.']);
}

public function destroy(Subcategoria $subcategoria)
{
    $categoriaId = $subcategoria->categoria_id;
    $subcategoria->delete();

    Subcategoria::where('categoria_id', $categoriaId)
        ->orderBy('orden')
        ->get()
        ->values()
        ->each(function ($sub, $posicion) {
            $sub->update(['orden' => $posicion]);
        });

    return response()->json(['mensaje' => 'Subcategoría eliminada.']);
}

    public function reordenar(Request $request)
{
    $request->validate(['ids' => 'required|array']);

    foreach ($request->ids as $posicion => $id) {
        Subcategoria::where('id', $id)->update(['orden' => $posicion]);
    }

    return response()->json(['mensaje' => 'Orden actualizado']);
}
}