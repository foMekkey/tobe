<?php

namespace App\Http\Controllers\Site;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use View;
use App\SiteSetting;
use App\Blog;
use App\Page;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $locale = 'ar';
    public $settings = [];

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if ($request->session()->has('lang')) {
                $lang = session('lang', session('lang'));
                $this->locale = $lang;

                \App::setLocale($lang);
            }

            $this->settings = SiteSetting::pluck('value', 'name');
            $this->settings['blog'] = Blog::where('lang', $this->locale)->orderBy('id', 'desc')->limit(2)->get();

            $this->settings['discover_pages'] = Page::where('lang', $this->locale)
                ->whereIn('key', ['training_and_courses', 'karizma'])
                ->get(['key', 'title']);
            $this->settings['individuals_services'] = Page::where('lang', $this->locale)
                ->whereIn('key', ['private-consultant', 'live_coaching', 'prepare-for-events', 'private-training', 'karizma'])
                ->get(['key', 'title']);
            $this->settings['companies_services'] = Page::where('lang', $this->locale)
                ->whereIn('key', ['consulting', 'leaders-qualification', 'staff-training', 'prepare-for-events-companies'])
                ->get(['key', 'title']);
            $this->settings['know_pages'] = Page::where('lang', $this->locale)
                ->whereIn('key', ['about-us', 'philosophy', 'why-tobe', 'whois-coach-ramadan', 'how-take-benefits'])
                ->get(['key', 'title']);
            View::share('settings', $this->settings);

            return $next($request);
        });
    }
}