<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkingShiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('working_shifts', function (Blueprint $table) {
            $table->id();
            $table->string('staff_id')->nullable();
            $table->string('teacher_id')->nullable();
            $table->string('supporter_id')->nullable();
            $table->string('room')->nullable();
            $table->string('start_time');
            $table->string('end_time');
            $table->integer('studylog_id');
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
        Schema::dropIfExists('working_shifts');
    }
}
