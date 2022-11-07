<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTermsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses_terms', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('course_id')->index('course_id');
            $table->text('rules_of_traversal')->nullable();
            $table->text('rules_of_achievement')->nullable();
            $table->text('learning_methods')->nullable();
            $table->text('collect_result')->nullable();
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
        Schema::dropIfExists('courses_terms');
    }
}
