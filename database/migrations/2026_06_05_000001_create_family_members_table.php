<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('family_members', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('cognome');
            $table->date('data_nascita');
            $table->string('luogo_nascita')->nullable();
            $table->string('relazione');
            $table->string('codice_fiscale', 16)->unique()->nullable();
            $table->string('telefono')->nullable();
            $table->string('email')->nullable();
            $table->string('indirizzo')->nullable();
            $table->string('foto')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('family_members');
    }
};
