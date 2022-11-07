<?php

namespace App\Http\Controllers\Site;
use App\Http\Controllers\Site\Controller;

use App\Courses;
use App\CategoiresCourses;
use App\CourseReview;

use Illuminate\Http\Request;
use Validator;

class CourseController extends Controller
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

    public function index($catId = '', Request $request)
    {
        if ($catId) {
            $courses = Courses::where('category_id', $catId)->where('lang', $this->locale);
        } else {
            $courses = Courses::where('lang', $this->locale);
        }
        
        if ($keyword = $request->input('keyword')) {
            $courses->where(function($q) use($keyword) {
                $q->where('name', 'like', '%' . $keyword . '%');
                $q->orWhere('desc', 'like', '%' . $keyword . '%');
                $q->orWhere('content', 'like', '%' . $keyword . '%');
            });
        }
        
        $courses = $courses->orderBy('id', 'desc')->paginate(16)->appends(request()->query());
        
        return view('site.courses.index', compact('courses'));
    }
    
    public function show($id)
    {
        $course = Courses::where('id', $id)->where('lang', $this->locale)->first();
        if (!$course) {
            abort(404);
        }
        
        $latestCourses = Courses::where('id', '!=', $id)->where('lang', $this->locale)->orderBy('id', 'desc')->limit(3)->get();
        $categories = CategoiresCourses::whereHas('courses')->where('lang', $this->locale)->orderBy('name', 'asc')->get();
        
        $reviewsCount = $reviewsAvg = 0;
        $reviewsGrouped = [];
        $reviews = CourseReview::select('rate', \DB::raw('count(*) as cnt'))->where('course_id', $id)->groupBy('rate')->get();
        if (count($reviews)) {
            $reviewsCount = $reviews->sum('cnt');
            $reviewsAvg = $reviews->sum('rate') / $reviewsCount;
            $reviewsGrouped = $reviews->pluck('cnt', 'rate')->toArray();
        }
        
        return view('site.courses.show', compact('course', 'latestCourses', 'categories', 'reviewsCount', 'reviewsAvg', 'reviewsGrouped'));
    }
    
    public function storeReview(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'rate' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'course_id' => 'required|exists:courses,id'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => 'invalid_request']); 
        }
        
        $data = $request->only(['course_id', 'rate', 'review', 'name', 'email']);
        $data['datetime'] = date('Y-m-d H:i:s');
        
        $result = CourseReview::insert($data);
        
        if ($result) {
            return response()->json(['success' => true]);
        }
        
        return response()->json(['error' => 'failed']);
    }
}
