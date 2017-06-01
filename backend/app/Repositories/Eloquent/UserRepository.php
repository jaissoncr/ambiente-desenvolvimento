<?php

namespace MLTools\Repositories\Eloquent;

use MLTools\Contracts\IUserRepository;
use MLTools\Models\Store;
use MLTools\Services\Meli\User as MeliUser;


class UserRepository implements IUserRepository
{

    protected $meli;
    protected $model;

    public function __construct(Store $model, MeliUser $meli)
    {
        $this->model = $model;
        $this->meli = $meli;
    }

    public function findByIdOrCreate($userData)
    {

        $user = $this->model->where('store_id', '=', $userData->id)->first();
        if(!$user) {
            $user = $this->model->create([
                'store_id'      => $userData->id,
                'site_id'       => $userData->site_id,
                'first_name'    => isset($userData->first_name) ? $userData->first_name : null,
                'last_name'     => isset($userData->last_name) ? $userData->last_name : null,
                'nickname'      => $userData->nickname,
                'email'         => isset($userData->email) ? $userData->email : null,
                'permalink'     => isset($userData->permalink) ? $userData->permalink : null,
                'avatar'        => isset($userData->avatar) ? $userData->avatar : null,
                'access_token'  => isset($userData->token) ? $userData->token : null,
                'token_type'    => isset($userData->token_type) ? $userData->token_type : null,
                'expires_in'    => isset($userData->expires_in) ? $userData->expires_in : null,
                'refresh_token' => isset($userData->refresh_token) ? $userData->refresh_token : null,
                'scope'         => isset($userData->scope) ? $userData->scope : null,
            ]);
        }

        $this->checkIfUserNeedsUpdating($userData, $user);

        return $user;

    }

    public function checkIfUserNeedsUpdating($userData, $user)
    {
        $socialData = [
            'first_name'    => isset($userData->first_name) ? $userData->first_name : null,
            'last_name'     => isset($userData->last_name) ? $userData->last_name : null,
            'nickname'      => $userData->nickname,
            'email'         => isset($userData->email) ? $userData->email : null,
            'permalink'     => isset($userData->permalink) ? $userData->permalink : null,
            'avatar'        => isset($userData->avatar) ? $userData->avatar : null,
            'access_token'  => isset($userData->token) ? $userData->token : null,
            'token_type'    => isset($userData->tokenType) ? $userData->tokenType : null,
            'expires_in'    => isset($userData->expiresIn) ? $userData->expiresIn : null,
            'refresh_token' => isset($userData->refreshToken) ? $userData->refreshToken : null,
            'scope'         => isset($userData->scope) ? $userData->scope : null,
        ];
        $dbData = [
            'first_name'    => $user->first_name,
            'last_name'     => $user->last_name,
            'nickname'      => $user->nickname,
            'email'         => $user->email,
            'permalink'     => $user->permalink,
            'avatar'        => $user->avatar,
            'access_token'  => $user->access_token,
            'token_type'    => $user->token_type,
            'expires_in'    => $user->expires_in,
            'refresh_token' => $user->refresh_token,
            'scope'         => $user->scope,
        ];

        if (!empty(array_diff($socialData, $dbData))) {
            $user->first_name    = isset($userData->first_name) ? $userData->first_name : null;
            $user->last_name     = isset($userData->last_name) ?  $userData->last_name : null;
            $user->nickname      = $userData->nickname;
            $user->email         = isset($userData->email) ? $userData->email : null;
            $user->permalink     = isset($userData->permalink) ? $userData->permalink : null;
            $user->avatar        = isset($userData->avatar) ? $userData->avatar : null;
            $user->access_token  = isset($userData->token) ? $userData->token : null;
            $user->token_type    = isset($userData->tokenType) ? $userData->tokenType : null;
            $user->expires_in    = isset($userData->expiresIn) ? $userData->expiresIn : null;
            $user->refresh_token = isset($userData->refreshToken) ? $userData->refreshToken : null;
            $user->scope         = isset($userData->scope) ? $userData->scope : null;
            $user->save();
        }

    }

    public function findUsersByStore(Store $user)
    {
        return $user->users()->withPivot('status')->get();
    }

    public function findMeliUserById($id)
    {
        if (!$this->meli)
            $this->meli = new MeliUser();

        return $this->meli->get($id);
    }

    public function addUser(Store $user, $id)
    {
        $meliUser = $this->findByIdOrCreate($this->findMeliUserById($id));
        if (!empty($meliUser))
            $user->addUser($meliUser);

        return;
    }

    public function removeUser(Store $user, $id)
    {
        $meliUser = $this->findByIdOrCreate($this->findMeliUserById($id));
        if (!empty($meliUser))
            $user->removeUser($meliUser);

        return;
    }

    public function block(Store $user, $block)
    {
        if (!$this->meli)
            $this->meli = new MeliUser();

        $meliRequest = $this->meli->block((int)$user->store_id, (int)$block);
        $userBlock = $user->users->where('store_id', $block)->first();
        if (isset($meliRequest['httpCode']) && ($meliRequest['httpCode'] == 201 || $meliRequest['httpCode'] == 304)) {
            $user->users()->where('store_id', $block)->sync([$userBlock->id => ['status' => 0]], false);
            return response()->json([
                "result"  => true,
                "message" => ($meliRequest['httpCode'] == 304) ? "Este usuário já se encontra bloqueado, atualiza a página e tente novamente." : "Usuário bloqueado com sucesso!",
                "status"  => 0
            ]);
        } else {
            return response()->json([
                "result"  => false,
                "message" => "Ocorreu um erro na requisição, tente novamente mais tarde.",
                "status"  => 1
            ]);
        }
    }

    public function unlock(Store $user, $blocked)
    {

        if (!$this->meli)
            $this->meli = new MeliUser();

        $meliRequest = $this->meli->unlock((int)$user->store_id, (int)$blocked);
        $userBlock = $user->users->where('store_id', $blocked)->first();
        if (isset($meliRequest['httpCode']) && ($meliRequest['httpCode'] == 200 || $meliRequest['httpCode'] == 404)) {
            $user->users()->where('store_id', $blocked)->sync([$userBlock->id => ['status' => 1]], false);
            return response()->json([
                "result"  => true,
                "message" => ($meliRequest['httpCode'] == 404) ? "Este usuário não se encontra bloqueado, atualiza a página e tente novamente." : "Usuário desbloqueado com sucesso!",
                "status"  => 1
            ]);
        } else {
            return response()->json([
                "result"  => false,
                "message" => "Ocorreu um erro na requisição, tente novamente mais tarde.",
                "status"  => 0
            ]);
        }

    }

}