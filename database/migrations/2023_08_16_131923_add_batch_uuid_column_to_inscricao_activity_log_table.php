<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBatchUuidColumnToInscricaoActivityLogTable extends Migration
{
    public function up()
    {
        Schema::connection(config('activitylog.database_connection'))->table('inscricao_activity_log', function (Blueprint $table) {
            $table->uuid('batch_uuid')->nullable()->after('properties');
        });
    }

    public function down()
    {
        Schema::connection(config('activitylog.database_connection'))->table('inscricao_activity_log', function (Blueprint $table) {
            $table->dropColumn('batch_uuid');
        });
    }
}
