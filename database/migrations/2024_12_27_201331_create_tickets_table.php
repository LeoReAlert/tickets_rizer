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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('assunto');
            $table->text('descricao');
            $table->foreignId('vendedor_id')->nullable()->constrained('users')->onDelete('set null'); // Relacionando com User
            $table->enum('status', ['Aberto', 'Em andamento', 'Atrasado', 'Resolvido'])->default('Aberto');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
