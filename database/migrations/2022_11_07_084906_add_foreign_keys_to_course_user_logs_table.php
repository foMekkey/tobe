<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToCourseUserLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('course_user_logs', function (Blueprint $table) {
            $table->foreign(['course_lesson_id'])->references(['id'])->on('course_lessons')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['course_user_id'])->references(['id'])->on('course_users')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('course_user_logs', function (Blueprint $table) {
            $table->dropForeign('course_user_logs_course_lesson_id_foreign');
            $table->dropForeign('course_user_logs_course_user_id_foreign');
        });
    }
}
