<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection(config('activitylog.database_connection'))->table(config('activitylog.table_name'), function (Blueprint $table) {
            $table->index(['subject_type', 'subject_id']);
            $table->index(['causer_type', 'causer_id']);
        });
    }

    public function down(): void
    {
        Schema::connection(config('activitylog.database_connection'))->table(config('activitylog.table_name'), function (Blueprint $table) {
            $table->dropIndex(['subject_type', 'subject_id']);
            $table->dropIndex(['causer_type', 'causer_id']);
        });
    }
};
