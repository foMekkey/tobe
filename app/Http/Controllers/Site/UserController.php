<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Site\Controller;
use Illuminate\Http\Request;
use App;
use Auth;
use Session;
use App\User;

class UserController extends Controller
{
    # login page
    public function getLogin()
    {
        return view('site.auth.login');
    }

    public function doLogin(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6',
            'email'    => 'required|email'
        ]);

        if (auth()->attempt($request->only(['email', 'password']), $request->rememberme)) {
            if (!empty($request->referrer_url)) {
                return redirect($request->referrer_url);
            }

            // add points
            $settings = \App\Setting::whereIn('name', ['check_points_group', 'enter'])->pluck('value', 'name')->toArray();
            if (auth()->user()->role == 3 && $settings['check_points_group'] == 'on' && $settings['enter']) {
                if (!auth()->user()->points) {
                    auth()->user()->points = $settings['enter'];
                    auth()->user()->save();
                } else {
                    auth()->user()->increment('points', $settings['enter']);
                }
            }

            return redirect()->route('home');
        } else {
            return redirect()->route('login')->withErrors([
                'login' => 'invalid_email_or_password',
            ]);
        }
    }

    # register page
    public function getRegister()
    {
        return view('site.auth.register');
    }

    # login 
    public function doRegister(Request $request)
    {
        $request->validate([
            'f_name'      => 'required',
            'l_name'      => 'required',
            'email'       => 'required|email|max:190|unique:users',
            'password'    => 'required',
            'confirm_pass' => 'required|same:password',
            'agree_terms' => 'required',
        ], [
            'f_name.required'      => __('site.first_name_required'),
            'l_name.required'      => __('site.second_name_required'),
            'user_name.required'   => __('site.username_required'),
            'email.required'       => __('site.email_required'),
            'email.unique'         => __('site.email_exist'),
            'confirm_pass.same'    => __('site.confirm_pass_not_match'),
            'agree_terms.required' => __('site.you_must_agree_terms'),
        ]);

        $user = new User;
        $user->f_name    = $request->f_name;
        $user->l_name    = $request->l_name;
        $user->user_name = $request->f_name . ' ' . $request->l_name;
        $user->email     = strtolower($request->email);
        $user->password  = bcrypt($request->password);
        $user->type      = 3;
        $user->role      = 3;
        $user->status    = 1;
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
        return view('site.auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);
        $userModel = User::where('email', $request->only('email', 'activation_code'))->first();
        Mail::to($userModel->email)->send(new passwordNotification($userModel));
        return redirect(url('/'))->with('success', 'check your email');
    }

    public function resendRememberToken()
    {
        return view('site.auth.passwords.reset');
    }
}