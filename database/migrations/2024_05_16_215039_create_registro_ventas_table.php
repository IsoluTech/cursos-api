<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('registro_ventas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_cliente');
            $table->string('direccion');
            $table->string('numero_telefono');
            $table->string('email');
            $table->integer('documento');
            $table->decimal('total', 8, 2);
            $table->decimal('iva', 8, 2);
            $table->decimal('subtotal', 8, 2);
            $table->string('giro')->nullable();
            $table->string('registro_num')->nullable();
            $table->string('documento_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_ventas');
    }
};
