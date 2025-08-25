<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Site\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Rules\Recaptcha;
use App\Mail\AccountActivation;
use App\Jobs\SendActivationEmail;
use Illuminate\Support\Str;

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

        $getUserByEmail = User::where('email', $request->email)->first();

        if ($getUserByEmail) {
            // التحقق من حالة تفعيل الحساب
            if ($getUserByEmail->status == 0) {
                return redirect()->route('login')->with('error', __('site.account_not_activated'));
            }

            \DB::table('sessions')->where('user_id', $getUserByEmail->id)->delete();
        }

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

            if (in_array(auth()->user()->role, [1, 6])) {
                return redirect()->route('courses');
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

    # register with AJAX support
    public function doRegister(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'f_name'      => 'required',
            'l_name'      => 'required',
            'email'       => 'required|email|max:190|unique:users',
            'password'    => 'required|min:8',
            'confirm_pass' => 'required|same:password',
            'agree_terms' => 'required',
            'g-recaptcha-response' => ['required', new Recaptcha]
        ], [
            'f_name.required'      => __('site.first_name_required'),
            'l_name.required'      => __('site.second_name_required'),
            'email.required'       => __('site.email_required'),
            'email.unique'         => __('site.email_exist'),
            'password.min'         => __('site.password_min_length'),
            'confirm_pass.same'    => __('site.confirm_pass_not_match'),
            'agree_terms.required' => __('site.you_must_agree_terms'),
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // إنشاء رمز تفعيل
            $activationToken = Str::random(64);

            // إنشاء المستخدم
            $user = new User;
            $user->f_name    = $request->f_name;
            $user->l_name    = $request->l_name;
            $user->user_name = $request->f_name . ' ' . $request->l_name;
            $user->email     = strtolower($request->email);
            $user->password  = bcrypt($request->password);
            $user->type      = 3;
            $user->role      = 3;
            $user->status    = 0; // غير مفعل
            $user->activation_token = $activationToken;
            $user->save();

            // إنشاء رابط التفعيل
            $activationUrl = route('account.activate', [
                'token' => $activationToken,
                'email' => $user->email
            ]);

            // إرسال بريد التفعيل
            SendActivationEmail::dispatch($user, $activationUrl);

            // إرسال إشعار للمسؤول عن تسجيل مستخدم جديد
            \App\Jobs\SendNewUserNotification::dispatch($user);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => __('site.activation_email_sent'),
                    'redirect' => route('login')
                ]);
            }

            return redirect()->route('login')->with('success', __('site.activation_email_sent'));
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => __('site.registration_failed'),
                    'error' => $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', __('site.registration_failed'))->withInput();
        }
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

    /**
     * تفعيل حساب المستخدم
     */
    /**
     * تفعيل حساب المستخدم
     */
    public function activateAccount(Request $request)
    {
        $token = $request->token;
        $email = $request->email;

        // البحث عن المستخدم
        $user = User::where('email', $email)
            ->where('activation_token', $token)
            ->first();

        if (!$user) {
            return redirect()->route('login')->with('error', __('site.activation_failed'));
        }

        if ($user->status == 1) {
            return redirect()->route('login')->with('info', __('site.account_already_activated'));
        }

        // تفعيل الحساب
        $user->status = 1;
        $user->activation_token = null;
        $user->email_verified_at = now();
        $user->save();

        // إرسال إشعار للمسؤول عن تفعيل حساب المستخدم
        \App\Jobs\SendAccountActivationNotification::dispatch($user);

        // إرسال إشعار للمستخدم بتفعيل حسابه
        \App\Jobs\SendAccountActivatedUserNotification::dispatch($user);

        return redirect()->route('login')->with('success', __('site.account_activated'));
    }

    /**
     * عرض نموذج طلب إعادة إرسال بريد التفعيل
     */
    public function showResendActivationForm()
    {
        return view('site.auth.resend-activation');
    }

    /**
     * إعادة إرسال بريد التفعيل
     */
    public function resendActivation(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'g-recaptcha-response' => ['required', new Recaptcha]
        ], [
            'email.required' => __('site.email_required'),
            'email.email' => __('site.email_invalid'),
            'email.exists' => __('site.email_not_found'),
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->back()->with('error', __('site.email_not_found'));
        }

        if ($user->status == 1) {
            return redirect()->route('login')->with('info', __('site.account_already_activated'));
        }

        // إنشاء رمز تفعيل جديد
        $activationToken = Str::random(64);
        $user->activation_token = $activationToken;
        $user->save();

        // إنشاء رابط التفعيل
        $activationUrl = route('account.activate', [
            'token' => $activationToken,
            'email' => $user->email
        ]);

        // إرسال بريد التفعيل
        SendActivationEmail::dispatch($user, $activationUrl);


        return redirect()->route('login')->with('success', __('site.activation_email_resent'));
    }
}
