<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('card_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('card_id');
            $table->integer('studylog_id');
            $table->integer('student_id');
            $table->integer('day');
            $table->integer('fee');
            $table->integer('status');
            $table->string('reason')->nullable();
            $table->string('teacher_note')->nullable();
            $table->string('supporter_note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('card_logs');
    }
}
