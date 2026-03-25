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
            $table->text('what_went_well');
            $table->text('what_needs_improvement');
            $table->text('action_items');
            $table->timestamps();

            $table->unique(['user_id', 'sprint_id']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('retrospectives');
    }
};
