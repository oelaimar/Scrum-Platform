<?php

use App\Enums\SprintStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sprints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->string('name'); // like "sprint 1"
            $table->text('objective')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('status')->default(SprintStatus::PLANNED->value);
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('sprints');
    }
};
