<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseUserLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_user_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('course_user_id')->index('course_user_logs_course_user_id_foreign');
            $table->unsignedInteger('course_lesson_id')->index('course_user_logs_course_lesson_id_foreign');
            $table->tinyInteger('status')->default(0)->comment('0:pending – 1:done');
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
        Schema::dropIfExists('course_user_logs');
    }
}
