<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddToWorkingShiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('working_shifts', function (Blueprint $table) {
            $table->string('teacher_timestamp');
            $table->string('supporter_timestamp');
            $table->string('teacher_comment')->nullable();
            $table->string('supporter_comment')->nullable();
            $table->integer('status')->default(\App\Models\WorkingShift::UNVERIFIED);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('working_shifts', function (Blueprint $table) {
            //
        });
    }
}
