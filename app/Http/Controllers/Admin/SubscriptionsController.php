<?php

namespace App\Http\Controllers\Admin;

use App\Subscription;
use App\User;
use App\Courses;
use App\Bank;
use App\E_Wallet;
use App\DataTables\SubscriptionsDataTable;
use App\Http\Requests\SubscriptionRequest;
use App\CoursesUser;

use Mail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;

class SubscriptionsController extends Controller
{

    /**
     * @param SubscriptionsDataTable $subscriptionsDatatable
     * @return mixed
     */

    public function index(SubscriptionsDataTable $subscriptionsDatatable)
    {
        return $subscriptionsDatatable->render('backend.subscriptions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $students = User::where('type', 3)->pluck('user_name', 'id')->toArray();
        $courses = Courses::all()->pluck('name', 'id');
        $banks = Bank::select('acc_name_ar', 'acc_num', 'id')->get();
        $e_wallets = E_Wallet::select('number', 'company_name_ar', 'id')->get();
        return view('backend.subscriptions.create', compact('courses', 'students', 'banks', 'e_wallets'));
    }


    /**
     * @param SubscriptionRequest $subscriptionRequest
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function test_mail_view()
    {
        return view('emails.mail');
    }
    public function test_mail()
    {

        $user = User::find(47);
        Mail::send('emails.mail', ['title' =>  'Done',  'data' => $user], function ($message) use ($user) {
            $message->from('info@tobe.support', 'Tobe Support');
            $message->to($user['email']);
            $message->subject('تم الموافقه علي طلب اشتراكك');
        });
    }
    public function store(SubscriptionRequest $subscriptionRequest)
    {
        $data = $subscriptionRequest->only(['user_id', 'course_id', 'payment_method', 'amount', 'currency', 'amount', 'currency', 'status', 'transfer_date', 'bank_id', 'user_bank_acc_name', 'e_wallet_id', 'user_e_wallet_number']);
        Subscription::insert($data);
        if ($data['status'] == 1) { // register the user if not already exist
            $course = new CoursesUser();
            $exist = CoursesUser::where('course_id', $data['course_id'])->where('user_id', $data['user_id'])->exists();
            if (!$exist) {
                $course->course_id = $data['course_id'];
                $course->user_id = $data['user_id'];
                $course->save();
                $course = Courses::find($data['course_id']);
                $user = User::find(request('user_id'));

                Mail::send('emails.mail', ['title' =>  'تم الموافقه علي طلب اشتراكك بكورس ' . $course['name'],  'data' => $user], function ($message) use ($user) {
                    $message->from('info@tobe.support', 'Tobe Support');
                    $message->to($user['email']);
                    $message->subject('تم الموافقه علي طلب اشتراكك');
                });
            }
        }
        return redirect('subscriptions')->with(['success' =>  __('pages.success-add')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subscription = Subscription::find($id);
        $students = User::where('type', 3)->pluck('user_name', 'id')->toArray();
        $courses = Courses::all()->pluck('name', 'id');
        $banks = Bank::select('acc_name_ar', 'acc_num', 'id')->get();
        $e_wallets = E_Wallet::select('number', 'company_name_ar', 'id')->get();
        return view('backend.subscriptions.edit', compact('subscription', 'courses', 'students', 'banks', 'e_wallets'));
    }


    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'user_id' => 'required',
            'course_id' => 'required',
            'payment_method' => 'required',
            'status' => 'required',
            'transfer_date' => 'required',
            'bank_id' => 'sometimes|nullable',
            'user_bank_acc_name' => 'sometimes|nullable',
            'e_wallet_id' => 'sometimes|nullable',
            'user_e_wallet_number' => 'sometimes|nullable',
        ]);

        $data = $request->only(['user_id', 'course_id', 'payment_method', 'amount', 'currency', 'status', 'transfer_date', 'bank_id', 'user_bank_acc_name', 'e_wallet_id', 'user_e_wallet_number']);
        if ($data['status'] == 1) { // register the user if not already exist
            $course = new CoursesUser();
            $exist = CoursesUser::where('course_id', $data['course_id'])->where('user_id', $data['user_id'])->exists();
            if (!$exist) {
                $course->course_id = $data['course_id'];
                $course->user_id = $data['user_id'];
                $course->save();
                $course = Courses::find($data['course_id']);
                $user = User::find(request('user_id'));

                Mail::send('emails.mail', ['title' =>  'تم الموافقه علي طلب اشتراكك بكورس ' . $course['name'],  'data' => $user], function ($message) use ($user) {
                    $message->from('info@tobe.support', 'Tobe Support');
                    $message->to($user['email']);
                    $message->subject('تم الموافقه علي طلب اشتراكك');
                });
            }
        }
        Subscription::where('id', $id)->update($data);
        return redirect('subscriptions')->with(['success' =>  __('pages.success-edit')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $subscription = Subscription::find($id);

        $check = $subscription->delete();

        if ($check) {
            return Response::json($id, '200');
        } else {
            return redirect()->back()->with('error', __('pages.success-delete'));
        }
    }
}