<?php

namespace MLTools\Http\Controllers\Auth;

use Illuminate\Http\Request;
use MLTools\Http\Controllers\Controller;
use MLTools\Jobs\Meli\ItemsStore as ItemsStoreJob;
use MLTools\Services\Authenticate\AuthenticateUser;
use MLTools\Models\Store;

class AuthController extends Controller
{

    /**
     * Login view
     */
    public function info()
    {
        return view('info');
    }

    public function logout()
    {
        \Auth::logout();
        return redirect('/info');
    }

    /**
     * Login method
     */
    public function loginProvider(AuthenticateUser $authenticateUser, Request $request)
    {
        return $authenticateUser->execute($request->all(), $this);
    }

    /**
     * Logged
     *
     * @param  Store $user
     * @return
     */
    public function userHasLoggedIn(Store $user)
    {
        \Session::flash('message', 'Bem vindo, ' . $user->first_name . ' ' . $user->last_name);

        // Add job para buscar todos anuncios do usuário caso existirem novos... Jobs/Anuncios
        $this->dispatch(new ItemsStoreJob($user, 1));

        return redirect('/');
    }

    public function get()
    {
        return \Auth::user();
    }

}
