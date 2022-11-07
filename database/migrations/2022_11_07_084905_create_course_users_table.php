<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_users', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('course_id')->index('course_user_course_id_foreign');
            $table->unsignedInteger('user_id')->index('course_user_user_id_foreign');
            $table->tinyInteger('status')->nullable()->default(0)->comment('0:pending – 1:done');
            $table->timestamp('ended')->nullable();
            $table->dateTime('datetime')->nullable();
            $table->longText('mission_reply')->nullable();
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
        Schema::dropIfExists('course_users');
    }
}
