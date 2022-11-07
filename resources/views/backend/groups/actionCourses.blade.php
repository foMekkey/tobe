<?php

$groups = \App\CoursesGroup::where('course_id',$courses_id)->where('group_id',$group_id)->count();

?>


@if($groups == 1)
    <a href="{{ url('groups/destroy-courseFrom-List/'.$group_id .'/'.$courses_id) }}" class="btn btn-sm btn-clean btn-icon btn-icon-md" title=" الغاء الالتحاق">
        <i class="flaticon2-delete"></i>
    </a>

@else


    <a href="{{ url('groups/add-courseFrom-List/'.$group_id .'/'.$courses_id) }}" class="btn btn-sm btn-clean btn-icon btn-icon-md" title=" الالتحاق">
        <i class="la la-plus"></i>
    </a>

@endif

