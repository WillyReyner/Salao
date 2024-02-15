<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEditalActivityLogTable extends Migration
{
    public function up()
    {
        Schema::connection(config('activitylog.database_connection'))->create('edital_activity_log', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('log_name')->nullable();
            $table->text('description');
            $table->nullableMorphs('subject', 'subject');
            $table->nullableMorphs('causer', 'causer');
            $table->json('properties')->nullable();
            $table->timestamps();
            $table->index('log_name');
            $table->index(['subject_type', 'subject_id']);
            $table->index(['causer_type', 'causer_id']);
        });
    }

    public function down()
    {
        Schema::connection(config('activitylog.database_connection'))->dropIfExists('edital_activity_log');
    }
}
