<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Http\Request;
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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function redirectToGithub()
    {
        return Socialite::driver('github')->redirect();
    }

    public function handleGithubCallback()
    {
        $user = Socialite::driver('github')->user();
        $this->_registerOrLogin($user);
        return redirect()->route('home');
    }
    protected function _registerOrLogin($data)
    {
        //dd($data);
        $user = User::where('email', '=', $data->email)->first();

        if (!$user) {
            $user = new User();
            $user->firstname = $data->nickname;
            $user->email = $data->email;
            $user->avatar = $data->avatar;
            $user->github_token = $data->token;
            $user->save();
        }
        Auth::login($user);
    }
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login');
    }
}