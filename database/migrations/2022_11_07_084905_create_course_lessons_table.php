<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_lessons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number_lession', 60)->nullable();
            $table->unsignedInteger('course_id')->index('course_lessons_course_id_foreign');
            $table->string('name', 191);
            $table->mediumText('content')->nullable();
            $table->text('file')->nullable();
            $table->string('mime', 40)->nullable();
            $table->tinyInteger('type')->comment('1:video - 2:file - 3:quiz - 4:text');
            $table->tinyInteger('sort');
            $table->integer('period');
            $table->integer('numberQuestion')->nullable();
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
        Schema::dropIfExists('course_lessons');
    }
}
