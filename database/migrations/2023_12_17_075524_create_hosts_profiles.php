<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHostsProfiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hosts_profiles', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->longText("extras_information")->nullable();
            $table->string('current_branch')->nullable();
            $table->string('birthday')->nullable();
            $table->string('address')->nullable();
            $table->string('workspace')->nullable();
            $table->integer('pricing_id')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('hosts_profiles');
    }
}
