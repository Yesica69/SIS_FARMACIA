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
        Schema::create('detalle_ventas', function (Blueprint $table) {
            $table->id();

            $table->integer('cantidad');
           

            // Relación con 'productos'
            $table->unsignedBigInteger('venta_id');
        $table->foreign('venta_id')->references('id')->on('ventas')->onDelete('cascade');

        $table->unsignedBigInteger('producto_id');
        $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
        // Relación con 'laboratorios'
       
           
        

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_ventas');
    }
};
