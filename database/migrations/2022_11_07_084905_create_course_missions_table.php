<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseMissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_missions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('course_id')->index('course_missions_course_id_foreign');
            $table->string('title', 191);
            $table->text('description');
            $table->text('instructions');
            $table->tinyInteger('type');
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
        Schema::dropIfExists('course_missions');
    }
}
