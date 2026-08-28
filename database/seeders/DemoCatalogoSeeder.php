<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\ProductoImagen;
use App\Models\ProductoVariante;
use App\Models\Subcategoria;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DemoCatalogoSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = Categoria::all();

        if ($categorias->isEmpty()) {
            $this->command->warn('No hay categorías creadas. Crea las 5 categorías desde el admin antes de correr este seeder.');
            return;
        }

        $tallasDisponibles = ['XS', 'S', 'M', 'L', 'XL'];
        $coloresDisponibles = ['Negro', 'Blanco', 'Azul', 'Gris', 'Beige', 'Rojo', 'Verde'];

        // ===== 100 subcategorías repartidas entre las 5 categorías reales =====
        $subcategoriasCreadas = collect();

        for ($i = 1; $i <= 100; $i++) {
            $categoria = $categorias->random();
            $nombre = ucfirst(fake()->words(2, true)) . " $i";

            $subcategoriasCreadas->push(
                Subcategoria::create([
                    'categoria_id' => $categoria->id,
                    'nombre' => $nombre,
                    'slug' => Str::slug($nombre),
                    'orden' => $i,
                    'activo' => true,
                ])
            );
        }

        // ===== 100 productos repartidos entre esas subcategorías =====
        for ($i = 1; $i <= 100; $i++) {
            $subcategoria = $subcategoriasCreadas->random();
            $nombre = ucfirst(fake()->words(3, true)) . " $i";

            $producto = Producto::create([
                'subcategoria_id' => $subcategoria->id,
                'nombre' => $nombre,
                'slug' => Str::slug($nombre),
                'descripcion' => fake()->paragraph(2),
                'destacado' => fake()->boolean(15),
                'activo' => true,
            ]);

            // "Hogar" se deja sin variantes (como en la vida real); el resto tiene variantes el 80% de las veces
            $categoriaNombre = $subcategoria->categoria->nombre ?? '';
            $generarVariantes = $categoriaNombre !== 'Hogar' && fake()->boolean(80);
            $coloresDelProducto = [];

            if ($generarVariantes) {
                $tallas = fake()->randomElements($tallasDisponibles, rand(2, 4));
                $coloresDelProducto = fake()->randomElements($coloresDisponibles, rand(1, 3));

                foreach ($tallas as $talla) {
                    foreach ($coloresDelProducto as $color) {
                        ProductoVariante::create([
                            'producto_id' => $producto->id,
                            'talla' => $talla,
                            'color' => $color,
                            'stock' => fake()->numberBetween(0, 15), // algunos quedan en 0 (agotado) a propósito
                        ]);
                    }
                }
            }

            // ===== Fotos falsas: una por color si tiene variantes, si no 1-3 genéricas =====
            if (!empty($coloresDelProducto)) {
                foreach (array_values($coloresDelProducto) as $orden => $color) {
                    ProductoImagen::create([
                        'producto_id' => $producto->id,
                        'ruta' => $this->crearImagenFalsa($producto->nombre, $color),
                        'color' => $color,
                        'orden' => $orden,
                    ]);
                }
            } else {
                $cantidadFotos = rand(1, 3);
                for ($f = 0; $f < $cantidadFotos; $f++) {
                    ProductoImagen::create([
                        'producto_id' => $producto->id,
                        'ruta' => $this->crearImagenFalsa($producto->nombre, null),
                        'color' => null,
                        'orden' => $f,
                    ]);
                }
            }
        }

        $this->command->info('Listo: 100 subcategorías, 100 productos y sus fotos falsas creados.');
    }

    /**
     * Genera una imagen de prueba (fondo de color + nombre del producto) usando GD
     * y la guarda en storage/app/public/productos. Devuelve la ruta relativa
     * que se guarda en producto_imagenes.ruta.
     */
    private function crearImagenFalsa(string $texto, ?string $color): string
    {
        $paletas = [
            'Negro' => [32, 32, 30],
            'Blanco' => [244, 242, 235],
            'Azul' => [58, 92, 140],
            'Gris' => [142, 142, 136],
            'Beige' => [214, 201, 178],
            'Rojo' => [162, 58, 53],
            'Verde' => [75, 110, 80],
        ];

        [$r, $g, $b] = $paletas[$color] ?? [rand(180, 230), rand(180, 230), rand(180, 230)];

        $ancho = 800;
        $alto = 1000;
        $imagen = imagecreatetruecolor($ancho, $alto);

        $fondo = imagecolorallocate($imagen, $r, $g, $b);
        imagefill($imagen, 0, 0, $fondo);

        // Texto contrastante simple, centrado aproximadamente
        $brillo = ($r * 299 + $g * 587 + $b * 114) / 1000;
        $colorTexto = $brillo > 150
            ? imagecolorallocate($imagen, 26, 26, 24)
            : imagecolorallocate($imagen, 250, 248, 243);

        $lineasTexto = $color ? [$texto, "($color)"] : [$texto];
        $y = ($alto / 2) - (count($lineasTexto) * 12);
        foreach ($lineasTexto as $linea) {
            $x = ($ancho / 2) - (strlen($linea) * 5);
            imagestring($imagen, 5, (int) max(10, $x), (int) $y, $linea, $colorTexto);
            $y += 24;
        }

        $nombreArchivo = 'productos/' . Str::random(24) . '.jpg';
        $rutaCompleta = storage_path('app/public/' . $nombreArchivo);

        if (!is_dir(dirname($rutaCompleta))) {
            mkdir(dirname($rutaCompleta), 0755, true);
        }

        imagejpeg($imagen, $rutaCompleta, 82);
        imagedestroy($imagen);

        return $nombreArchivo;
    }
}