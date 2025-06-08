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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image')->nullable(); // caminho da imagem
            $table->decimal('price', 8, 2);
            $table->text('description');
            $table->enum('category', ['congelado', 'panificado', 'fruta', 'verdura']);
            $table->integer('quantity')->default(0); // Adiciona o campo quantidade
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};