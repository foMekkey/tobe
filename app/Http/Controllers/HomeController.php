<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\ContactMessageDatatable;
use App\DataTables\ConsultationDatatable;
use App\DataTables\TestimonialDatatable;
use Auth;
use Illuminate\Support\Facades\Mail;
use App\NewsletterSubscription;
use App\SiteSetting;
use App\UserNotification;
use Session;
use Carbon\Carbon;

class HomeController extends Controller
{
//    /**
//     * Create a new controller instance.
//     *
//     * @return void
//     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::check()) {
                return redirect(route('site-home'));
            }
            
            return $next($request);
        });
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->role == 1) {
            return redirect(route('courses'));
        } elseif (Auth::user()->role == 2) {
            return redirect(route('TrainerCourses'));
        } elseif (Auth::user()->role == 3) {
            return redirect(route('StudentCourses'));
        }

        //return view('home');
    }
    
    public function contactMessages(ContactMessageDatatable $contactMessageDatatable)
    {
        return $contactMessageDatatable->render('backend.contact_messages');
    }
    
    public function consultations(ConsultationDatatable $consultationDatatable)
    {
        return $consultationDatatable->render('backend.consultations');
    }
    
    public function consultationReply(Request $request)
    {
        if (empty($request->id) || empty($request->status) || ($request->status == '2' && empty($request->suggested_date))) {
            return response()->json(['error' => true], '200');
        }
        
        $consultation = \App\Consultation::where(['id' => $request->id, 'status' => '0'])->first();
        if (!$consultation) {
            return response()->json(['error' => true], '200');
        }
        
        $msg = 'تم اعتماد موعد الإستشارة" ' . $consultation->subject . '"';
        $consultation->status = $request->status;
        if ($request->status == '2') {
            $consultation->suggested_date = $request->suggested_date;
            $msg = 'تم ارسال تعديل مقترح لموعد الإستشارة" ' . $consultation->subject . '"';
        }
        $consultation->save();
        
        $notificationData = [
            'type' => 2,
            'user_id' => $consultation->user_id,
            'message' => $msg,
            'related_type' => 6,
            'related_id' => $consultation->id,
            'datetime' => Carbon::now()
        ];
        UserNotification::insert($notificationData);

        Session::flash('success', 'تم تعديل الحالة بنجاح');
        
        return response()->json(['success' => true], '200');
    }
    
    public function consultationSuggestedAction(Request $request)
    {
        if (empty($request->id) || empty($request->action) || !in_array($request->action, ['accept', 'reject'])) {
            return response()->json(['error' => true], '200');
        }
        
        $consultation = \App\Consultation::where(['id' => $request->id, 'status' => '2'])->first();
        if (!$consultation) {
            return response()->json(['error' => true], '200');
        }
        
        $msg = 'تم رفض الموعد المقترح للإستشارة " ' . $consultation->subject . '"';
        $consultation->status = ($request->action == 'accept' ? 1 : 3);
        if ($request->action == 'accept') {
            $msg = 'تم قبول الموعد المقترح للإستشارة " ' . $consultation->subject . '"';
            
            $consultation->date = $consultation->suggested_date;
        }
        $consultation->save();
        
        $notificationData = [
            'type' => 2,
            'user_id' => 1,
            'message' => $msg,
            'related_type' => 6,
            'related_id' => $consultation->id,
            'datetime' => Carbon::now()
        ];
        UserNotification::insert($notificationData);

        if ($request->action == 'accept') {
            Session::flash('success', 'تم قبول الموعد المقترح للإستشارة ');
        } else {
            Session::flash('success', 'تم رفض الموعد المقترح للإستشارة ');
        }
        
        return response()->json(['success' => true], '200');
    }
    
    public function consultationShow($id)
    {
        $consultation = \App\Consultation::findOrFail($id);
        
        return view('students.consultation_show', compact('consultation'));
    }
    
    public function testimonials(TestimonialDatatable $testimonialDatatable)
    {
        return $testimonialDatatable->render('backend.testimonials');
    }
    
    public function upload(Request $request)
    {
        $folder = 'services';
        if (!empty($request->folder)) {
            $folder = 'images';
        }
        if (isset($request->file) ||  $request->file != null) {
            return url('uploads/' . $request->file->store($folder));
        }
        
        return '';
    }
    
    public function newsletters() {
        return view('backend.newsletter_contact');
    }
    
    public function newslettersContact(Request $request)
    {
        $this->validate($request,[
            'title'=>'required',
            'content'=>'required'
        ]);
        
        $senderEmail = SiteSetting::where('name', 'email')->first()->value;
        $emails = NewsletterSubscription::get(['email']);
        foreach($emails as $email){
            Mail::send('emails.newsletter', ['content' => $request->content], function ($message) use($email, $senderEmail, $request) {
                $message->to($email->email)->from($senderEmail)->subject($request->title);
            });
        }
        
        return redirect('newsletters')->with(['success' =>  __('pages.success-send_newsletter')]);
    }
    
    public function markNotificationsAsRead()
    {
        \App\UserNotification::where('user_id', Auth::id())->update(['read_at' => \Carbon\Carbon::now()]);
    }
}
