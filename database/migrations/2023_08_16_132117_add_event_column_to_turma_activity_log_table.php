<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEventColumnToTurmaActivityLogTable extends Migration
{
    public function up()
    {
        Schema::connection(config('activitylog.database_connection'))->table('turma_activity_log', function (Blueprint $table) {
            $table->string('event')->nullable()->after('subject_type');
        });
    }

    public function down()
    {
        Schema::connection(config('activitylog.database_connection'))->table('turma_activity_log', function (Blueprint $table) {
            $table->dropColumn('event');
        });
    }
}
