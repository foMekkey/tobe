<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPeriodTypeToCourseLessonsMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('course_lessons', function (Blueprint $table) {
            $table->enum('period_type', ['hour', 'day', 'week', 'month'])->after('period')->default('hour');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('course_lessons', function (Blueprint $table) {
            $table->dropColumn('period_type');
        });
    }
}