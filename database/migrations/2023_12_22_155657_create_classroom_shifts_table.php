<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassroomShiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classroom_shifts', function (Blueprint $table) {
            $table->id();
            $table->integer('classroom_schedule_id');
            $table->integer('classroom_id');
            $table->string('start_time');
            $table->string('end_time');
            $table->string('room');
            $table->integer('supporter_id');
            $table->integer('teacher_id');
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
        Schema::dropIfExists('classroom_shifts');
    }
}
