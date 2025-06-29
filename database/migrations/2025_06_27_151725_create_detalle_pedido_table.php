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
    Schema::create('detalle_pedido', function (Blueprint $table) {
        $table->id('id_detalle_pedido');
        $table->foreignId('id_pedido')->constrained('pedido');
        $table->foreignId('id_producto')->constrained('productos'); // Relación con productos
        $table->integer('cantidad');
        $table->decimal('sub_total', 10, 2);
        $table->tinyInteger('estado');
        $table->timestamps(); // Si usas `created_at` y `updated_at`
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_pedido');
    }
};
