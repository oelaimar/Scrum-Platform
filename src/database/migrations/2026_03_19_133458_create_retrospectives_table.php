<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('retrospectives', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sprint_id')->constrained()->cascadeOnDelete();
            $table->text('positives');
            $table->text('difficulties');
            $table->text('improvements');
            $table->timestamps();

            $table->unique(['user_id', 'sprint_id']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('retrospectives');
    }
};
