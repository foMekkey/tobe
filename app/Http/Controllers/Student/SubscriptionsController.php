<?php

namespace App\Http\Controllers\Student;

use App\Subscription;
use App\CoursesUser;
use App\Courses;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubscriptionRequest;
use Mail;

class SubscriptionsController extends Controller
{
    public function store(SubscriptionRequest $subscriptionRequest)
    {
        $data = $subscriptionRequest->only([
            'user_id', 'course_id', 'payment_method', 'amount',
            'currency', 'status', 'transfer_date', 'bank_id', 'user_bank_acc_name', 'e_wallet_id', 'user_e_wallet_number'
        ]);
        if (
            !CoursesUser::where('course_id', $data['course_id'])->where('user_id', $data['user_id'])->exists() &&
            !Subscription::where('user_id', $data['user_id'])->where('course_id', $data['course_id'])->where('status', 0)->exists()
        ) {
            Subscription::insert($data);
            $user = auth()->user();
            $course = Courses::find($data['course_id']);
            $title = 'تم استلام طلب اشتراكك بكورس' . $course['name'] . ' وستتم المراجعة في اقرب وقت';
            Mail::send('emails.mail', ['title' =>   $title,  'data' => $user], function ($message) use ($user) {
                $message->from('info@tobe.support', 'ToBe Support');
                $message->to($user->email);
                $message->subject('تم استلام طلب الاشتراك');
            });
            return redirect('student/courses/catalog')->with(['success' =>  __('pages.success-add')]);
        }
        return redirect()->back()->with(['success' =>  __('pages.success-add')]);
    }
}