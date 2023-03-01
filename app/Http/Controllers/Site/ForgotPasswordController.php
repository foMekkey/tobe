<?php

namespace App\Http\Controllers\Site;
use App\Http\Controllers\Site\Controller;

use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Mail;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('guest');
    }
    
    
    public function forgotPassword()
    {
        $title = 'نسيت كلمة المرور؟';
        return view('forgotPassword',compact('title'));
    }

    public function postForgotPassword()
    {
      $data = $this->validate(request(),[
        'email' =>'required|email',
        ],[
        
      ]);

      $user = \App\User::where('email',request('email'))->first();
      
      if (!$user) {
         // return 'omar';
        session()->flash('error','البريد الألكتروني غير موجود');
        return back();
      }
      
      $user['reset_token'] = str_random(60);
      $user->save();
      
      $link = url('password/reset/'.$user['reset_token'].'?email='. urlencode($user['email']));
      
      $title = 'يمكنك تغيير كلمة المرور من خلال الرابط التالي' . '<br>' . $link;
      Mail::send('emails.mail', ['title' =>   $title ,  'data' => $user], function ($message) use ($user)
        {
           $message->from('info@tobe.support', 'ToBe Support');
           $message->to($user['email']);
           $message->subject('إستعادة كلمة المرور');
      });
      session()->flash('save','تم ارسال نموذج استعادة البيانات لحسابكم');
      return redirect()->back()->with('msg','omar');
    }
    
    public function passwordResBlade($token)
    {
      $title = 'تغيير كلمة المرور';
      $email = request('email');
      return view('reset',compact('title','token','email'));
    }

    public function changePassword()
    {

      $data = $this->validate(request(),[
        'password'                =>'required',
        'repassword'              =>'required|same:password',
        ],[
        'password.required'       =>trans('admin.password_required'),
        'repassword.required'     =>trans('admin.repassword_required'),
        'repassword.same'         =>trans('admin.repassword_same'),
      ]);
      if(empty(request('token'))){
        session()->flash('error','أنتهت صلاحية الرابط');
        return Redirect(url('forgot-your-password'));  
      }
      $user = \App\User::where('reset_token', request('token'))->where('email', request('email'))->first();
      if (!$user) {
        session()->flash('error','أنتهت صلاحية الرابط');
        return Redirect(url('forgot-your-password'));
      }
      

      $user->password = bcrypt(request('password'));
      $user['reset_token'] = null;
      
      if ($user->update()) {
        session()->flash('save','تم تغيير كلمة المرور بنجاح');
        $user->save();
        return Redirect(url('/login'));
      }else{
        session()->flash('save','حاول مجددا');
        return Redirect(url('forgot-your-password'));
      }

      
    }
    
}
