<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_dashboard_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('widget_id');
            $table->boolean('enabled')->default(true);
            $table->unsignedSmallInteger('order')->default(0);
            $table->unsignedTinyInteger('column_width')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'widget_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_dashboard_preferences');
    }
};
