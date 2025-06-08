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
        Schema::table('pedidos', function (Blueprint $table) {
            $table->unsignedBigInteger('cliente_id')->after('id');
            // Se quiser garantir integridade, descomente a linha abaixo:
            // $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            // Se adicionou foreign key, descomente a linha abaixo:
            // $table->dropForeign(['cliente_id']);
            $table->dropColumn('cliente_id');
        });
    }
};