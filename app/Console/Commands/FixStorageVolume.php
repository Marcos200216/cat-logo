<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FixStorageVolume extends Command
{
    protected $signature = 'storage:fix-volume';
    protected $description = 'Asegura que storage/app/public sea un symlink hacia el volumen persistente';

    public function handle()
    {
        $publicPath = storage_path('app/public');
        $volumePath = storage_path('app/public-data');

        // Si no existe la carpeta del volumen, no hacemos nada (entorno local, sin volumen)
        if (!is_dir($volumePath) && !is_link($publicPath)) {
            $this->info('No hay volumen configurado en este entorno. Nada que hacer.');
            return self::SUCCESS;
        }

        // Si ya es symlink, no hacemos nada más
        if (is_link($publicPath)) {
            $this->info('storage/app/public ya es un symlink. Todo en orden.');
            return self::SUCCESS;
        }

        // Crear la carpeta del volumen si no existe
        if (!is_dir($volumePath)) {
            mkdir($volumePath, 0775, true);
        }

        // Si el volumen está vacío de datos reales (sin contar lost+found), copiamos lo que trae el build desde git
        $hasRealData = is_dir($volumePath . '/productos') || is_dir($volumePath . '/categorias');

        if (!$hasRealData && is_dir($publicPath)) {
            $this->info('Copiando archivos existentes hacia el volumen...');
            $this->copyDirectory($publicPath, $volumePath);
        }

        // Reemplazar la carpeta normal por un symlink hacia el volumen
        if (is_dir($publicPath) && !is_link($publicPath)) {
            $this->deleteDirectory($publicPath);
        }

        if (!is_link($publicPath)) {
            symlink($volumePath, $publicPath);
            $this->info('Symlink creado: storage/app/public -> storage/app/public-data');
        }

        return self::SUCCESS;
    }

    private function copyDirectory($source, $destination)
    {
        $dir = opendir($source);
        @mkdir($destination, 0775, true);

        while (($file = readdir($dir)) !== false) {
            if ($file == '.' || $file == '..') {
                continue;
            }

            $srcPath = $source . '/' . $file;
            $destPath = $destination . '/' . $file;

            if (is_dir($srcPath)) {
                $this->copyDirectory($srcPath, $destPath);
            } else {
                copy($srcPath, $destPath);
            }
        }

        closedir($dir);
    }

    private function deleteDirectory($dir)
    {
        if (!is_dir($dir)) {
            return;
        }

        $items = scandir($dir);
        foreach ($items as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }

            $path = $dir . '/' . $item;
            if (is_dir($path) && !is_link($path)) {
                $this->deleteDirectory($path);
            } else {
                unlink($path);
            }
        }

        rmdir($dir);
    }
}