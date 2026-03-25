<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('task_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('status')->default('todo');
            $table->string('solution_link')->nullable();
            $table->text('teacher_feedback')->nullable();
            $table->timestamps();

            $table->unique(['task_id', 'user_id']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('task_progress');
    }
};
