<?php

namespace MLTools\Http\Controllers\Auth;

use MLTools\User;
use Validator;
use MLTools\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * Redirect the user to the OAuth page
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('meli')->redirect();
    }

    /**
     * Obtain the user information from OAuth server.
     */
    public function handleProviderCallback()
    {
        // $socialize_user = Socialize::with($provider)->user();
        // $facebook_user_id = $socialize_user->getId(); // unique facebook user id
        //
        // $user = User::where('facebook_user_id', $facebook_user_id)->first();
        //
        // // register (if no user)
        // if (!$user) {
        //     $user = new User;
        //     $user->facebook_id = $facebook_user_id;
        //     $user->save();
        // }
        //
        // // login
        // Auth::loginUsingId($user->id);
        //
        // return redirect('/');
    }

}
