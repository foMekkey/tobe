<?php

     $course = \App\CoursesUser::where('user_id',$user_id)->where('course_id',$course_id)->count();

?>


@if($course == 1)
    <a href="{{ url('trainer/courses/destroy-courseFrom-List/'.$user_id .'/'.$course_id) }}" class="btn btn-sm btn-clean btn-icon btn-icon-md" title=" الغاء الالتحاق">
        <i class="flaticon2-delete"></i>
    </a>

@else


    <a href="{{ url('trainer/courses/add-courseFrom-List/'.$user_id .'/'.$course_id) }}" class="btn btn-sm btn-clean btn-icon btn-icon-md" title=" الالتحاق">
        <i class="la la-plus"></i>
    </a>

@endif


