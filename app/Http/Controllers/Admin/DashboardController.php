<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Subcategoria;
use App\Models\Producto;

class DashboardController extends Controller
{
    public function index()
    {
        $canal = session('admin_canal', 'normal');

        $totalCategorias = Categoria::where('canal', $canal)->count();

        $totalSubcategorias = Subcategoria::whereHas('categoria', fn($q) => $q->where('canal', $canal))->count();

        $totalProductos = Producto::whereHas('subcategoria.categoria', fn($q) => $q->where('canal', $canal))->count();

        $productosActivos = Producto::where('activo', true)
            ->whereHas('subcategoria.categoria', fn($q) => $q->where('canal', $canal))
            ->count();

        $productosDestacados = Producto::where('destacado', true)
            ->whereHas('subcategoria.categoria', fn($q) => $q->where('canal', $canal))
            ->count();

        // Productos por categoría, para el gráfico de barras
        $productosPorCategoria = Categoria::where('canal', $canal)
            ->withCount('productos')
            ->orderByDesc('productos_count')
            ->get();

        // Productos con stock bajo (umbral configurable)
        // Productos con stock bajo (umbral configurable) — solo aplica al canal normal,
        // el mayorista no maneja variantes con stock
        $umbralStockBajo = 5;

        if ($canal === 'mayorista') {
            $productosBajoStock = collect();
            $productosSinStock = 0;
        } else {
            $productosBajoStock = Producto::with('subcategoria.categoria', 'variantes')
                ->whereHas('subcategoria.categoria', fn($q) => $q->where('canal', $canal))
                ->whereHas('variantes', function ($q) use ($umbralStockBajo) {
                    $q->where('stock', '<=', $umbralStockBajo);
                })
                ->get()
                ->map(function ($producto) use ($umbralStockBajo) {
                    $producto->stock_minimo = $producto->variantes->min('stock');
                    return $producto;
                })
                ->filter(fn($p) => $p->stock_minimo <= $umbralStockBajo)
                ->sortBy('stock_minimo')
                ->take(5);

            $productosSinStock = Producto::whereHas('subcategoria.categoria', fn($q) => $q->where('canal', $canal))
                ->whereDoesntHave('variantes', function ($q) {
                    $q->where('stock', '>', 0);
                })
                ->count();
        }

        $ultimosProductos = Producto::with('subcategoria.categoria', 'imagenes')
            ->whereHas('subcategoria.categoria', fn($q) => $q->where('canal', $canal))
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'canal',
            'totalCategorias',
            'totalSubcategorias',
            'totalProductos',
            'productosActivos',
            'productosDestacados',
            'productosPorCategoria',
            'productosBajoStock',
            'productosSinStock',
            'ultimosProductos'
        ));
    }
}
