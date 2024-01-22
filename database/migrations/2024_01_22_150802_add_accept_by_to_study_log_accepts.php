<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAcceptByToStudyLogAccepts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('studylogs_accepts', function (Blueprint $table) {
            $table->string('accepted_by')->after('accepted_by_system')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('studylogs_accepts', function (Blueprint $table) {
            $table->dropColumn('accepted_by');
        });
    }
}
