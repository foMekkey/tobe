<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoursesLessons extends Model
{
    protected $table = 'course_lessons';
    protected $fillable =['course_id', 'name', 'content', 'type', 'sort'];

    public function Course(){
        return $this->belongsTo(Courses::class);
    }

    /*public function CourseSection(){
        return $this->belongsTo(CourseSection::class);
    }*/

    public static function lessonType(){
        return [
            '1'=>__('pages.video'),
            '2'=>__('pages.file'),
            '3'=>__('pages.quiz'),
            '4'=>__('pages.text'),
        ];
    }

    /*public static function LessonInSameSection($id)
    {
        $sections = CourseSection::where('course_id',$id)->get();

       if(isset($sections) && $sections != null){
           $coursesLessons =[];
           foreach ($sections as $section){
               $coursesLessons[$section->title] = CoursesLessons::where('course_id',$id)->where('course_section_id',$section->id)->orderBy('sort')->get();
           }
       }else{
            $coursesLessons =[];
       }


       return $coursesLessons;

    }*/
}
