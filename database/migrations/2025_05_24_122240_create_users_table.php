<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // ID primário
            $table->string('name'); // Nome do usuário
            $table->string('email')->unique(); // E-mail único
            $table->timestamp('email_verified_at')->nullable(); // Verificação de e-mail (opcional)
            $table->string('password'); // Senha
            $table->rememberToken(); // Token para "lembrar-me"
            $table->timestamps(); // created_at e updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
