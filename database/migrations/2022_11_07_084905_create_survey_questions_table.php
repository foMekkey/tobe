<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_questions', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('survey_id')->index('survey_id');
            $table->string('question');
            $table->boolean('type')->comment('1:text, 2:select, 3:multiple_select');
            $table->text('allowed_options')->nullable();
            $table->boolean('is_required')->nullable()->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('survey_questions');
    }
}
