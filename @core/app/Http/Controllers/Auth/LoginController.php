<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    public function redirectTo(){
        return route('user.home');
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:admin')->except('logout');
    }
    /**
     * Override username functions
     * @since 1.0.0
     * */
    public function username() {
        return 'username';
    }

    /**
     * show admin login page
     * @since 1.0.0
     * */
    public function showAdminLoginForm(){
        return view('auth.admin.login');
    }
    /**
     * admin login system
     * */
    public function adminLogin(Request $request)
    {
        $this->validate($request, [
            'username'   => 'required|string',
            'password' => 'required|min:6'
        ],[
            'username.required'   => __('username required'),
            'password.required' => __('password required')
        ]);

        $throttleKey = Str::transliterate(Str::lower($request->input('username')).'|'.$request->ip());

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return response()->json([
                'msg' => __('Too many login attempts. Please try again in :seconds seconds.', ['seconds' => $seconds]),
                'type' => 'danger',
                'status' => 'not_ok'
            ]);
        }

        if (Auth::guard('admin')->attempt(['username' => $request->username, 'password' => $request->password], $request->get('remember'))) {
            RateLimiter::clear($throttleKey);

            return response()->json([
               'msg' => __('Login Success Redirecting'),
               'type' => 'success',
               'status' => 'ok'
            ]);
        }

        RateLimiter::hit($throttleKey, 60);

        return response()->json([
            'msg' => __('Your Username or Password Is Wrong !!'),
            'type' => 'danger',
            'status' => 'not_ok'
        ]);
    }
    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('frontend.user.login');
    }


}
