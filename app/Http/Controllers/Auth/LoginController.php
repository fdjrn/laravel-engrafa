<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Session;

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
    protected $redirectTo = '/homepage';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    /**
     * Redirect user when authenticated
     *
     * override function from trait RedirectsUsers->redirectPath()
     * @return string
     */
    /*public function redirectPath()
    {
        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/homepage';
    }*/

    /**
     * Logout Handler
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect($this->redirectTo);
    }

    // public function index(Request $request){
    //     return view('login');
    // }

    // public function login(Request $request){
    //     $email = $request->email;
    //     $password = $request->password;

    //     if ($email == 'admin@gmail.com' && $password == 'admin') {
    //         # code...
    //         $user = array('email' => $email,
    //             'password' => $password );

    //         Session::put('user',$user);
    //         return view('dashboard/dashboard');
    //     }else{
    //         return redirect('login');
    //     }
    // }
}
