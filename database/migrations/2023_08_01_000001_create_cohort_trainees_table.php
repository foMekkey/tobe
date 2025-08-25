<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCohortTraineesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cohort_trainees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cohort_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            // $table->foreign('cohort_id')->references('id')->on('cohorts')->onDelete('cascade');
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unique(['cohort_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cohort_trainees');
    }
}