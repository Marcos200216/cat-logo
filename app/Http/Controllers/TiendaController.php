<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;

class TiendaController extends Controller
{
    public function home()
    {
        $modo = request()->routeIs('mayorista.*') ? 'mayorista' : 'normal';

        $categorias = Categoria::where('activo', true)
            ->where('canal', $modo)
            ->orderBy('orden')
            ->get();

        $productosDestacados = Producto::where('destacado', true)
            ->where('activo', true)
            ->whereHas('subcategoria.categoria', fn ($q) => $q->where('canal', $modo))
            ->with([
                'imagenes' => fn ($query) => $query->orderBy('orden'),
                'subcategoria.categoria',
            ])
            ->latest()
            ->limit(8)
            ->get();

        return view('tienda.home', compact('categorias', 'productosDestacados', 'modo'));
    }

    public function categoria(string $slug, Request $request)
{
    $modo = request()->routeIs('mayorista.*') ? 'mayorista' : 'normal';

    $categoria = Categoria::where('slug', $slug)
        ->where('activo', true)
        ->where('canal', $modo)
        ->with(['subcategorias' => function ($query) {
            $query->where('activo', true)->orderBy('orden');
        }])
        ->firstOrFail();

       $subSlug = $request->query('sub');
    $buscar = $request->query('buscar');

    $productos = Producto::where('activo', true)
        ->whereHas('subcategoria', function ($query) use ($categoria) {
            $query->where('categoria_id', $categoria->id)->where('activo', true);
        })
        ->when($subSlug, function ($query) use ($subSlug) {
            $query->whereHas('subcategoria', fn ($q) => $q->where('slug', $subSlug));
        })
        ->when($buscar, function ($query) use ($buscar) {
            $query->where('nombre', 'like', "%{$buscar}%");
        })
        ->with([
            'imagenes' => fn ($query) => $query->orderBy('orden'),
            'subcategoria',
        ])
        ->orderBy('destacado', 'desc')
        ->latest()
        ->paginate(12)
        ->withQueryString();

    return view('tienda.categoria', compact('categoria', 'productos', 'subSlug', 'buscar', 'modo'));
}

public function producto(string $slug)
{
    $modo = request()->routeIs('mayorista.*') ? 'mayorista' : 'normal';

    $producto = Producto::where('slug', $slug)
        ->where('activo', true)
        ->whereHas('subcategoria.categoria', fn ($q) => $q->where('canal', $modo))
        ->with([
            'imagenes' => fn ($query) => $query->orderBy('orden'),
            'variantes',
            'subcategoria.categoria',
        ])
        ->firstOrFail();

    $relacionados = Producto::where('activo', true)
        ->where('subcategoria_id', $producto->subcategoria_id)
        ->where('id', '!=', $producto->id)
        ->with(['imagenes' => fn ($query) => $query->orderBy('orden')])
        ->inRandomOrder()
        ->limit(4)
        ->get();

    return view('tienda.producto', compact('producto', 'relacionados', 'modo'));
}
}