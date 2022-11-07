<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\SiteSetting;

use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::orderBy('sort', 'asc')->get();

    	return view('backend.site_setting',compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->all();
        foreach ($data as $k => $v) {
            SiteSetting::where('name', $k)->update(['value' => $v]);
        }
        
    	return back()->with(['success' =>  __('pages.success-edit')]);
    }
}
