<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_profiles', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unique();
            $table->integer('status');
            $table->integer('gender');
            $table->string('english_name')->nullable();
            $table->string('school')->nullable();
            $table->string('facebook')->nullable();
            $table->string('address')->nullable();
            $table->integer('user_ref')->nullable();
            $table->integer('created_by')->nullable();
            $table->dateTime('birthday')->nullable();
            $table->longText('extra_information')->nullable();
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
        Schema::dropIfExists('student_profiles');
    }
}
