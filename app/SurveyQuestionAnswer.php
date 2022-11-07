<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SurveyQuestionAnswer extends Model
{
    protected $guarded = [];
    public $timestamps = false;
    
    public function surveyQuestion()
    {
        return $this->belongsTo(SurveyQuestion::class, 'survey_question_id', 'id');
    }
}
