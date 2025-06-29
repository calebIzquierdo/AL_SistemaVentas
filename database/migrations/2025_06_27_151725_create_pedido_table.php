<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
        {
    Schema::create('pedido', function (Blueprint $table) {
        $table->id('id_pedido');
        $table->foreignId('id_usuario')->constrained(); // Relación con la tabla `usuarios`
        $table->date('fecha_pedido');
        $table->string('estado_pedido');
        $table->decimal('total', 10, 2);
        $table->tinyInteger('estado');
        $table->timestamps(); // Si usas `created_at` y `updated_at`
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedido');
    }
};
