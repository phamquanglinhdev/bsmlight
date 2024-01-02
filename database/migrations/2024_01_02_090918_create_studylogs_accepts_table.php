<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudylogsAcceptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('studylogs_accepts', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('studylog_id');
            $table->string('accepted_time');
            $table->integer('accepted_by_system');
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
        Schema::dropIfExists('studylogs_accepts');
    }
}
