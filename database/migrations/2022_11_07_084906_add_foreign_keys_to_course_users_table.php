<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToCourseUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('course_users', function (Blueprint $table) {
            $table->foreign(['course_id'], 'course_user_course_id_foreign')->references(['id'])->on('courses')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['user_id'], 'course_user_user_id_foreign')->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('course_users', function (Blueprint $table) {
            $table->dropForeign('course_user_course_id_foreign');
            $table->dropForeign('course_user_user_id_foreign');
        });
    }
}
