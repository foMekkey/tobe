<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;
use Auth;
use Session;
use App\User;

class LoginController extends Controller
{   
    # login page
    public function getLogin()
    {
        return view('backend.auth.login');
    }

    # login 
    public function doLogin(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6',
            'email'    => 'required|email'
        ]);


        if( auth()->attempt($request->only(['email','password']),$request->rememberme))
        {
             return redirect()->route('home');
        }else{
            return redirect()->route('login');
        }
    }

    # register page
    public function getRegister()
    {
        return view('backend.auth.register');
    }

    # login 
    public function doRegister(Request $request)
    {
        $request->validate([
            'f_name'      => 'required',
            'l_name'      => 'required',
            'user_name'   => 'required',
            'email'       =>'max:190|unique:users',
            'password'    => 'required'
        ],[
            'f_name.required' => __('pages.first_name_required'),
            'l_name.required' => __('pages.second_name_required'),
            'user_name.required' => __('pages.username_required'),
            'email.required' => __('pages.email_required'),
            'email.unique' => __('pages.email_exist'),
        ]);

        $user = new User;
        $user->f_name    = $request->f_name;
        $user->l_name    = $request->l_name;
        $user->user_name = $request->user_name;
        $user->email     = $request->email;
        $user->status     = 1;
        $user->password  = bcrypt($request->password);
        $user->save();

        Auth::loginUsingId($user->id);
        return back(); 
    }

    # logout
    public function logout()
    {
        Auth::logout();
        return redirect(url('/login'));
    }


    public function showLinkRequestForm()
    {
        return view('front.auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);
        $userModel = User::where('email', $request->only('email','activation_code'))->first();
        Mail::to($userModel->email)->send(new passwordNotification($userModel));
        return redirect(url('/'))->with('success','check your email');
    }

    public function resendRememberToken()
    {
        return view('front.auth.passwords.reset');
    }

    # ar lang
    public function ArLang()
    {
        session()->put('lang','ar');
        App::setlocale('ar');
        // return session()->get('lang');
        return back();
    }

    # en lang
    public function EnLang()
    {
        session()->put('lang','en');
        App::setlocale('en');
        // return session()->get('lang');
        return back();
    }

}
