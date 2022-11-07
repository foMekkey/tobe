<?php

namespace App\Http\Controllers\Site;
use App\Http\Controllers\Site\Controller;

use App\Service;

class ServiceController extends Controller
{
//    /**
//     * Create a new controller instance.
//     *
//     * @return void
//     */
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $services = Service::where('lang', $this->locale)->orderBy('id', 'desc')->paginate(15);
        
        return view('site.services.index', compact('services'));
    }
    
    public function show($id)
    {
        $latestServices = Service::where('id', '!=', $id)->where('lang', $this->locale)->orderBy('id', 'desc')->limit(6)->get();
        $service = Service::where('id', $id)->where('lang', $this->locale)->first();
        if (!$service) {
            abort(404);
        }
        
        return view('site.services.show', compact('service', 'latestServices'));
    }
}
