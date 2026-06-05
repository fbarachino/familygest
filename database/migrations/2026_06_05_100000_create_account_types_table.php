<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('account_types', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('icona')->nullable();
            $table->string('colore')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('account_types');
    }
};
