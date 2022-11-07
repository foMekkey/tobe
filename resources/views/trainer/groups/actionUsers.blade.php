<?php

$groups = \App\GroupMember::where('student_id',$student_id)->where('group_id',$group_id)->count();

?>


@if($groups == 1)
    <a href="{{ url('trainer/groups/destroy-groupFrom-List/'.$group_id .'/'.$student_id) }}" class="btn btn-sm btn-clean btn-icon btn-icon-md" title=" الغاء الالتحاق">
        <i class="flaticon2-delete"></i>
    </a>

@else


    <a href="{{ url('trainer/groups/add-groupFrom-List/'.$group_id .'/'.$student_id) }}" class="btn btn-sm btn-clean btn-icon btn-icon-md" title=" الالتحاق">
        <i class="la la-plus"></i>
    </a>

@endif


