<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->increments('id');
            $table->char('lang', 2)->nullable();
            $table->unsignedInteger('user_id')->nullable()->index('courses_user_id_foreign');
            $table->unsignedInteger('category_id')->nullable()->index('courses_category_id_foreign');
            $table->string('name', 191);
            $table->integer('price');
            $table->integer('level');
            $table->text('desc');
            $table->mediumText('content')->nullable();
            $table->tinyInteger('status');
            $table->string('image', 191);
            $table->text('tags')->nullable();
            $table->tinyInteger('hide_from_catalog');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('duration');
            $table->text('rules')->nullable();
            $table->text('complete_rules')->nullable();
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
        Schema::dropIfExists('courses');
    }
}
