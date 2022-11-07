<?php

namespace App\Http\Controllers\Site;
use App\Http\Controllers\Site\Controller;

use App\Blog;

class BlogController extends Controller
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
        $blog = Blog::where('lang', $this->locale)->orderBy('id', 'desc')->paginate(15);
        
        return view('site.blog.index', compact('blog'));
    }
    
    public function show($id)
    {
        $latestNews = Blog::where('id', '!=', $id)->where('lang', $this->locale)->orderBy('id', 'desc')->limit(3)->get();
        $blog = Blog::where('id', $id)->where('lang', $this->locale)->first();
        if (!$blog) {
            abort(404);
        }
        
        return view('site.blog.show', compact('blog', 'latestNews'));
    }
}
