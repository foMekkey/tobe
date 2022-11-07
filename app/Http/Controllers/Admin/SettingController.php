<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Setting;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    # index
    public function index()
    {
    	$site_name             = Setting::where('name','site_name')->first()->value;
        $site_disc             = Setting::where('name','site_disc')->first()->value;
        $default_lang          = Setting::where('name','default_lang')->first()->value;
        $out_side_baner        = Setting::where('name','out_side_baner')->first()->value;
        $in_side_baner         = Setting::where('name','in_side_baner')->first()->value;
        $prevent_multi_enter   = Setting::where('name','prevent_multi_enter')->first()->value;
        $prevent_phone_enter   = Setting::where('name','prevent_phone_enter')->first()->value;
        $index_out_course      = Setting::where('name','index_out_course')->first()->value;
        $view_summary_session  = Setting::where('name','view_summary_session')->first()->value;
        $ink_based_bbb         = Setting::where('name','ink_based_bbb')->first()->value;
        $ink_safety_bbb        = Setting::where('name','ink_safety_bbb')->first()->value;
        $maximum_capacity      = Setting::where('name','maximum_capacity')->first()->value;
        $register_type         = Setting::where('name','register_type')->first()->value;
        $user_default_type     = Setting::where('name','user_default_type')->first()->value;
        $default_group         = Setting::where('name','default_group')->first()->value;
        $terms_of_service      = Setting::where('name','terms_of_service')->first()->value;

        # second tap
        $register_type         = Setting::where('name','register_type')->first()->value;
        $user_default_type     = Setting::where('name','user_default_type')->first()->value;
        $default_group         = Setting::where('name','default_group')->first()->value;
        $terms_of_service      = Setting::where('name','terms_of_service')->first()->value;

        # thirs tap
        $check_points_group                 = Setting::where('name','check_points_group')->first()->value;

        $enter                              = Setting::where('name','enter')->first()->value;
        $check_enter                        = Setting::where('name','check_enter')->first()->value;

        $complete_unit                      = Setting::where('name','complete_unit')->first()->value;
        $check_complete_unit                = Setting::where('name','check_complete_unit')->first()->value;

        $complete_course                    = Setting::where('name','complete_course')->first()->value;
        $check_complete_course              = Setting::where('name','check_complete_course')->first()->value;

        $complete_test                      = Setting::where('name','complete_test')->first()->value;
        $check_complete_test                = Setting::where('name','check_complete_test')->first()->value;

        $complete_mission                   = Setting::where('name','complete_mission')->first()->value;
        $check_complete_mission             = Setting::where('name','check_complete_mission')->first()->value;

        $complete_unit_with_treaner         = Setting::where('name','complete_unit_with_treaner')->first()->value;
        $check_complete_unit_with_treaner   = Setting::where('name','check_complete_unit_with_treaner')->first()->value;

        $subject_or_comment                 = Setting::where('name','subject_or_comment')->first()->value;
        $check_subject_or_comment           = Setting::where('name','check_subject_or_comment')->first()->value;

        $vote                               = Setting::where('name','vote')->first()->value;
        $check_vote                         = Setting::where('name','check_vote')->first()->value;

        #--

        $check_badges_group                 = Setting::where('name','check_badges_group')->first()->value;
        $activity_badges                    = Setting::where('name','activity_badges')->first()->value;
        $learn_badges                       = Setting::where('name','learn_badges')->first()->value;
        $trust_badges                       = Setting::where('name','trust_badges')->first()->value;
        $complete_badges                    = Setting::where('name','complete_badges')->first()->value;

        # --

        $check_levels_group                  = Setting::where('name','check_levels_group')->first()->value;

        $upgrade_level_points                = Setting::where('name','upgrade_level_points')->first()->value;
        $check_upgrade_level_points          = Setting::where('name','check_upgrade_level_points')->first()->value;

        $upgrade_level_courses               = Setting::where('name','upgrade_level_courses')->first()->value;
        $check_upgrade_level_courses         = Setting::where('name','check_upgrade_level_courses')->first()->value; //council_group_of_pioneers

        $upgrade_level_badges                = Setting::where('name','upgrade_level_badges')->first()->value;
        $check_upgrade_level_badges          = Setting::where('name','check_upgrade_level_badges')->first()->value;

        # ---
        $council_group_of_pioneers           = Setting::where('name','council_group_of_pioneers')->first()->value;
        $show_points                         = Setting::where('name','show_points')->first()->value;
        $show_Logos                          = Setting::where('name','show_Logos')->first()->value;
        $show_courses                        = Setting::where('name','show_courses')->first()->value;
        $show_certificates                   = Setting::where('name','show_certificates')->first()->value;




    	return view('backend.setting.setting',compact(
            'site_name',
            'site_disc',
            'default_lang',
            'out_side_baner',
            'in_side_baner',
            'prevent_multi_enter',
            'prevent_phone_enter',
            'index_out_course',
            'view_summary_session',
            'ink_based_bbb',
            'ink_safety_bbb',
            'maximum_capacity',
            'register_type',
            'user_default_type',
            'default_group',
            'terms_of_service',
            'register_type',
            'user_default_type',
            'default_group',
            'terms_of_service',
            'check_points_group',

            'enter',
            'check_enter',
            'complete_unit',
            'check_complete_unit',
            'complete_course',
            'check_complete_course',
            'complete_test',
            'check_complete_test',
            'complete_mission',
            'check_complete_mission',
            'complete_unit_with_treaner',
            'check_complete_unit_with_treaner',
            'subject_or_comment',
            'check_subject_or_comment',
            'vote',
            'check_vote',

            'check_badges_group',
            'activity_badges',
            'learn_badges',
            'trust_badges',
            'complete_badges',

            'check_levels_group',
            'upgrade_level_points',
            'check_upgrade_level_points',
            'upgrade_level_courses',
            'check_upgrade_level_courses',
            'upgrade_level_badges',
            'check_upgrade_level_badges',

            'council_group_of_pioneers',
            'show_points',
            'show_Logos',
            'show_courses',
            'show_certificates'
        ));
    }

    # update first tap
    public function UpdateFristTap(Request $request)
    {
    	$settings = Setting::get();
    	foreach ($settings as $setting)
    	{
    		$set = Setting::Where('name',$setting->name)->first();
    		$set->value = $request[$setting->name];
    		$set->save();
    	}
    	return back()->with(['success' =>  __('pages.success-edit')]);
    }

    # update second tap
    public function UpdateSecondTap(Request $request) //terms_of_service check_points_group
    {
    	$register_type = Setting::where('name','register_type')->first();
        $register_type->value = $request->register_type;
        $register_type->save();

        $user_default_type = Setting::where('name','user_default_type')->first();
        $user_default_type->value = $request->user_default_type;
        $user_default_type->save();

        $default_group = Setting::where('name','default_group')->first();
        $default_group->value = $request->default_group;
        $default_group->save();

        $terms_of_service = Setting::where('name','terms_of_service')->first();
        $terms_of_service->value = $request->terms_of_service;
        $terms_of_service->save();

    	return back()->with(['success' =>  __('pages.success-edit')]);
    }

    # update thirs tap
    public function UpdateThirdTap(Request $request)
    {
        # first part ----

        $check_points_group = Setting::where('name','check_points_group')->first();
        $check_points_group->value = $request->check_points_group;
        $check_points_group->save();

        $enter = Setting::where('name','enter')->first();
        $enter->value = $request->enter;
        $enter->save();

        $check_enter = Setting::where('name','check_enter')->first();
        $check_enter->value = $request->check_enter;
        $check_enter->save();

         # ---
        $complete_unit = Setting::where('name','complete_unit')->first();
        $complete_unit->value = $request->complete_unit;
        $complete_unit->save();

        $check_complete_unit = Setting::where('name','check_complete_unit')->first();
        $check_complete_unit->value = $request->check_complete_unit;
        $check_complete_unit->save();

        # ---
        $complete_course = Setting::where('name','complete_course')->first();
        $complete_course->value = $request->complete_course;
        $complete_course->save();

        $check_complete_course = Setting::where('name','check_complete_course')->first();
        $check_complete_course->value = $request->check_complete_course;
        $check_complete_course->save();

        # ---
        $complete_test = Setting::where('name','complete_test')->first();
        $complete_test->value = $request->complete_test;
        $complete_test->save();

        $check_complete_test = Setting::where('name','check_complete_test')->first();
        $check_complete_test->value = $request->check_complete_test;
        $check_complete_test->save();

        # ---
        $complete_mission = Setting::where('name','complete_mission')->first();
        $complete_mission->value = $request->complete_mission;
        $complete_mission->save();

        $check_complete_mission = Setting::where('name','check_complete_mission')->first();
        $check_complete_mission->value = $request->check_complete_mission;
        $check_complete_mission->save();

        # ---
        $complete_unit_with_treaner = Setting::where('name','complete_unit_with_treaner')->first();
        $complete_unit_with_treaner->value = $request->complete_unit_with_treaner;
        $complete_unit_with_treaner->save();

        $check_complete_unit_with_treaner = Setting::where('name','check_complete_unit_with_treaner')->first();
        $check_complete_unit_with_treaner->value = $request->check_complete_unit_with_treaner;
        $check_complete_unit_with_treaner->save();

        # ---
        $subject_or_comment = Setting::where('name','subject_or_comment')->first();
        $subject_or_comment->value = $request->subject_or_comment;
        $subject_or_comment->save();

        $check_subject_or_comment = Setting::where('name','check_subject_or_comment')->first();
        $check_subject_or_comment->value = $request->check_subject_or_comment;
        $check_subject_or_comment->save();

        # ---
        $vote = Setting::where('name','vote')->first();
        $vote->value = $request->vote;
        $vote->save();

        $check_vote = Setting::where('name','check_vote')->first();
        $check_vote->value = $request->check_vote;
        $check_vote->save();

        # second part

        $check_badges_group = Setting::where('name','check_badges_group')->first();
        $check_badges_group->value = $request->check_badges_group;
        $check_badges_group->save();

        $activity_badges = Setting::where('name','activity_badges')->first();
        $activity_badges->value = $request->activity_badges;
        $activity_badges->save();

        $learn_badges = Setting::where('name','learn_badges')->first();
        $learn_badges->value = $request->learn_badges;
        $learn_badges->save();

        $trust_badges = Setting::where('name','trust_badges')->first();
        $trust_badges->value = $request->trust_badges;
        $trust_badges->save();

        $complete_badges = Setting::where('name','complete_badges')->first();
        $complete_badges->value = $request->complete_badges;
        $complete_badges->save();

        # third part
        $check_levels_group = Setting::where('name','check_levels_group')->first();
        $check_levels_group->value = $request->check_levels_group;
        $check_levels_group->save();

        $upgrade_level_points = Setting::where('name','upgrade_level_points')->first();
        $upgrade_level_points->value = $request->upgrade_level_points;
        $upgrade_level_points->save();

        $check_upgrade_level_points = Setting::where('name','check_upgrade_level_points')->first();
        $check_upgrade_level_points->value = $request->check_upgrade_level_points;
        $check_upgrade_level_points->save();

        $upgrade_level_courses = Setting::where('name','upgrade_level_courses')->first();
        $upgrade_level_courses->value = $request->upgrade_level_courses;
        $upgrade_level_courses->save();

        $check_upgrade_level_courses = Setting::where('name','check_upgrade_level_courses')->first();
        $check_upgrade_level_courses->value = $request->check_upgrade_level_courses;
        $check_upgrade_level_courses->save();

        $upgrade_level_badges = Setting::where('name','upgrade_level_badges')->first();
        $upgrade_level_badges->value = $request->upgrade_level_badges;
        $upgrade_level_badges->save();

        $check_upgrade_level_badges = Setting::where('name','check_upgrade_level_badges')->first();
        $check_upgrade_level_badges->value = $request->check_upgrade_level_badges;
        $check_upgrade_level_badges->save();

        # fourth part
        $council_group_of_pioneers = Setting::where('name','council_group_of_pioneers')->first();
        $council_group_of_pioneers->value = $request->council_group_of_pioneers;
        $council_group_of_pioneers->save();

        $show_points = Setting::where('name','show_points')->first();
        $show_points->value = $request->show_points;
        $show_points->save();

        $show_Logos = Setting::where('name','show_Logos')->first();
        $show_Logos->value = $request->show_Logos;
        $show_Logos->save();

        $show_courses = Setting::where('name','show_courses')->first();
        $show_courses->value = $request->show_courses;
        $show_courses->save();

        $show_certificates = Setting::where('name','show_certificates')->first();
        $show_certificates->value = $request->show_certificates;
        $show_certificates->save();

        return back()->with(['success' =>  __('pages.success-edit')]);
    }


}
