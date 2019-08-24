<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\AccesslogController;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

//
    protected function authenticated(Request $request, $user)
    {

        if(!$user->is_active && ($user->email_verifed==null || $user->email_verifed=='')){
//            dd('hello');
            auth()->logout();
            return back()->withErrors(['message'=>'you are not active user']);
        }

        (new AccesslogController())->store($request, $user);

        $url = Session::get('url.intended');
        $roles = Auth::user()->hasRoleType();

        if ($roles == 'admin' || $roles == 'sub-admin') {
            strpos($url, 'admin') !== false ?:
                redirect()->intended('');
            $this->redirectTo = '/admin/dashboard';

        } else if ($roles == 'user') {
            strpos($url, 'user') !== false ?:
                redirect()->intended('');
            $this->redirectTo = '/user/dashboard';

        } else {
            $this->redirectTo = '/home';
        }
    }
}
