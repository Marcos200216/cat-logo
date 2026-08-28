<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('productos', function (Blueprint $table) {
        $table->id();
        $table->foreignId('subcategoria_id')->constrained('subcategorias')->cascadeOnDelete();
        $table->string('nombre', 150);
        $table->string('slug', 150)->unique();
        $table->text('descripcion')->nullable();
        $table->boolean('destacado')->default(false);
        $table->boolean('activo')->default(true);
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('productos');
}
};
