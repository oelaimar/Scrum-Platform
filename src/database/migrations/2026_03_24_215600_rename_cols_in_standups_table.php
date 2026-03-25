<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('standups', function (Blueprint $table) {
            $table->renameColumn('work_done', 'did_yesterday');
            $table->renameColumn('work_planned', 'will_do_today');
        });
    }

    public function down(): void
    {
        Schema::table('standups', function (Blueprint $table) {
            $table->renameColumn('did_yesterday', 'work_done');
            $table->renameColumn('will_do_today', 'work_planned');
        });
    }
};
