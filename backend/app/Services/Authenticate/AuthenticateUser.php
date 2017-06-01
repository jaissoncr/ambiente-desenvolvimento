<?php

namespace MLTools\Services\Authenticate;

use Illuminate\Contracts\Auth\Guard;
use Laravel\Socialite\Contracts\Factory as Socialite;
use MLTools\Repositories\Eloquent\UserRepository;
use Request;

class AuthenticateUser
{
    private $socialite;
    private $auth;
    private $users;

    public function __construct(Socialite $socialite, Guard $auth, UserRepository $users)
    {
        $this->socialite = $socialite;
        $this->users = $users;
        $this->auth = $auth;
    }

    public function execute($request, $listener, $provider = 'meli')
    {
        if (!$request) return $this->getAuthorizationFirst($provider);

        $user = $this->users->findByIdOrCreate($this->getSocialUser($provider));
        $this->auth->login($user, true);

        return $listener->userHasLoggedIn($user);
    }

    private function getAuthorizationFirst($provider) {
        return $this->socialite->driver($provider)->redirect();
    }

    private function getSocialUser($provider) {
        return $this->socialite->driver($provider)->user();
    }

}
