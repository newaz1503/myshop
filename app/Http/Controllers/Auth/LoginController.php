<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;

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
    protected $redirectTo = 'user.dashboard';


    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('layouts.frontend_app');
    }


    public function login(Request $request)
    {
        if ($this->validateCheck($request)) {
            $email = $request->email;
            $arr = [
                'email'     => $email,
                'password'  => $request->password
            ];

            $admin = User::where('email', $email)->first();
            if (!empty($admin)) {
                if (Auth::attempt($arr, $request->remember)) {
                    return response([
                        'message'   => "Login Successfully",
                        'id'        => Auth::user()->id ?? "",
                        'name'      => Auth::user()->name ?? ""
                    ], 200);
                } else {
                    return response([
                        'message'  => "Your Login Information is Wrong!"
                    ], 201);
                }
            } else {
                return response([
                    'message'  => "Email does not match our records!"
                ], 201);
            }
        }
    }



    //Google Login
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    //Google callback
    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->stateless()->user();
        $this->_registerOrLoginUser($user);
        return redirect()->route('user.dashboard');
    }

    //Facebook Login
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->stateless()->redirect();
    }

    //facebook callback
    public function handleFacebookCallback()
    {
        $user = Socialite::driver('facebook')->stateless()->user();
        $this->_registerOrLoginUser($user);
        return redirect()->route('home');
    }

    //Github Login
    public function redirectToTwitter(){
        return Socialite::driver('github')->stateless()->redirect();
    }

    //github callback
    public function handleTwitterCallback(){

        $user = Socialite::driver('twitter')->stateless()->user();

        $this->_registerOrLoginUser($user);
        return redirect()->route('home');
    }

    protected function _registerOrLoginUser($data)
    {
        $user = User::where('email',$data->email)->first();
        if(!$user){
            $user = new User();
            $user->name = $data->name;
            $user->user_type = "online";
            $user->email = $data->email;
            $user->provider_id = $data->id;
            $user->avatar = $data->avatar;
            $user->save();
        }
       Auth::login($user);
    }

    /**
     * Validation check====
     */
    public function validateCheck($request)
    {
        return $request->validate([
            "email"     => "required",
            "password"  => "required"
        ]);
    }


    public function loginCheck()
    {
        if (Auth::user()) {
            return response([
                'message'   => "Login Successfully",
                'id'        => Auth::user()->id ?? "",
                'name'      => Auth::user()->name ?? ""
            ], 200);
        }
        return response([
            'message'   => "Unauthorized",
        ], 201);
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout', 'loginCheck');
    }
}
