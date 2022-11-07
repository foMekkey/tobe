<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiveSessionRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('live_session_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->index('live_session_requests_user_id_foreign');
            $table->unsignedInteger('trainer_id')->index('live_session_requests_trainer_id_foreign');
            $table->unsignedInteger('course_id')->index('live_session_requests_course_id_foreign');
            $table->tinyInteger('status')->comment('0:pending – 1:accepted – 3:completed – 4:rejected');
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
        Schema::dropIfExists('live_session_requests');
    }
}
