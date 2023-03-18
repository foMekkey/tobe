<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Site\Controller;

use App\Service;
use App\Courses;
use App\Testimonial;
use App\Blog;
use App\ContactMessage;
use App\Consultation;
use App\Faq;
use App\NewsletterSubscription;
use App\Page;
use App\Rules\Recaptcha;
use Illuminate\Http\Request;
use Validator;
use Session;

class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $services = Service::where('lang', $this->locale)->orderBy('id', 'desc')->limit(10)->get();
        $courses = Courses::where('lang', $this->locale)->where('status', 1)->where('start_date', '>', date('Y-m-d'))->orderBy('id', 'desc')->limit(10)->get();
        $testimonials = Testimonial::orderBy('id', 'desc')->limit(5)->with('user')->get();
        $blog = Blog::where('lang', $this->locale)->orderBy('id', 'desc')->limit(10)->get();

        return view('site.home', compact('services', 'courses', 'testimonials', 'blog'));
    }

    public function about()
    {
        $testimonials = Testimonial::orderBy('id', 'desc')->limit(5)->with('user')->get();

        return view('site.about', compact('testimonials'));
    }

    public function know()
    {
        return view('site.know');
    }

    public function discover()
    {
        return view('site.discover');
    }

    public function showPage($key = '')
    {
        $page = Page::where('lang', $this->locale)->where('key', $key)->first();

        return view('site.page', compact('page', 'key'));
    }

    public function faq()
    {
        $faqs = Faq::all();
        return view('site.faq', compact('faqs'));
    }

    public function contact()
    {
        return view('site.contact');
    }

    public function storeContact(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
            'g-recaptcha-response' => ['required', new Recaptcha],
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => 'invalid_request']);
        }

        $data = $request->only(['name', 'email', 'message']);
        $data['datetime'] = date('Y-m-d H:i:s');

        $result = ContactMessage::insert($data);

        if ($result) {
            return response()->json(['success' => true]);
        }

        return response()->json(['error' => 'failed']);
    }

    public function consult()
    {
        if (!auth()->check()) {
            Session::flash('referrer_url', route('site-consult'));

            return redirect(route('login'));
        }

        return view('site.consult');
    }

    public function storeConsult(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required',
            'hours' => 'required',
            'session_type' => 'required',
            'subject' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => 'invalid_request']);
        }

        $data = $request->only(['date', 'hours', 'session_type', 'subject']);
        $data['user_id'] = auth()->user()->id;
        if (isset($request->file) || $request->file != null) {
            $data['file'] = $request->file->store('consultations');
        }

        $result = Consultation::create($data);

        if ($result) {
            return response()->json(['success' => true]);
        }

        return response()->json(['error' => 'failed']);
    }

    public function storeNewsletter(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:newsletter_subscriptions',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => 'invalid_request']);
        }

        $data = $request->only(['email']);
        $data['datetime'] = date('Y-m-d H:i:s');

        $result = NewsletterSubscription::insert($data);

        if ($result) {
            return response()->json(['success' => true]);
        }

        return response()->json(['error' => 'failed']);
    }
}