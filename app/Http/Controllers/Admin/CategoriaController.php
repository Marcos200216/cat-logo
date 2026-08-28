<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoriaController extends Controller
{
    public function index()
    {
        $canal = session('admin_canal', 'normal');

        $categorias = Categoria::where('canal', $canal)->orderBy('orden')->get();
        return view('admin.categorias.index', compact('categorias'));
    }

    public function store(Request $request)
{
    $datos = $request->validate([
        'nombre' => ['required', 'string', 'max:100'],
        'activo' => ['nullable', 'boolean'],
        'imagen' => ['nullable', 'image', 'max:2048'],
    ]);

    $canal = session('admin_canal', 'normal');

    $datos['slug'] = Str::slug($datos['nombre']);
    $datos['activo'] = $request->boolean('activo');
    $datos['canal'] = $canal;
    $datos['orden'] = (int) (Categoria::where('canal', $canal)->max('orden') ?? -1) + 1;

    if ($request->hasFile('imagen')) {
        $datos['imagen'] = $request->file('imagen')->store('categorias', 'public');
    }

    Categoria::create($datos);

    return response()->json(['mensaje' => 'Categoría creada correctamente.']);
}

    public function update(Request $request, Categoria $categoria)
{
    $datos = $request->validate([
        'nombre' => ['required', 'string', 'max:100'],
        'activo' => ['nullable', 'boolean'],
        'imagen' => ['nullable', 'image', 'max:2048'],
    ]);

    $datos['slug'] = Str::slug($datos['nombre']);
    $datos['activo'] = $request->boolean('activo');

    if ($request->hasFile('imagen')) {
        $datos['imagen'] = $request->file('imagen')->store('categorias', 'public');
    }

    $categoria->update($datos);

    return response()->json(['mensaje' => 'Categoría actualizada correctamente.']);
}

   public function destroy(Categoria $categoria)
{
    $canal = $categoria->canal;

    $categoria->delete();

    Categoria::where('canal', $canal)->orderBy('orden')->get()->values()->each(function ($cat, $posicion) {
        $cat->update(['orden' => $posicion]);
    });

    return response()->json(['mensaje' => 'Categoría eliminada.']);
}

    public function reordenar(Request $request)
{
    $request->validate(['ids' => 'required|array']);

    foreach ($request->ids as $posicion => $id) {
        Categoria::where('id', $id)->update(['orden' => $posicion]);
    }

    return response()->json(['mensaje' => 'Orden actualizado']);
}
}