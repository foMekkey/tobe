<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_registrations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('cohort_id');
            $table->string('full_name');
            $table->date('birth_date');
            $table->string('education');
            $table->text('previous_courses')->nullable();
            $table->string('current_job');
            $table->text('additional_tasks')->nullable();
            $table->date('join_date');
            $table->text('special_skills')->nullable();
            $table->text('communication_problems')->nullable();
            $table->text('personal_problems')->nullable(); // سيكون مشفراً
            $table->text('skills_to_develop')->nullable();
            $table->text('message_to_consultant')->nullable();
            $table->string('mobile_number');
            $table->string('whatsapp_number')->nullable();
            $table->string('email');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();

            // $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            // $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            // $table->foreign('cohort_id')->references('id')->on('cohorts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_registrations');
    }
}