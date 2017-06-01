<?php

namespace MLTools\Services\Meli;

/**
 * User Meli Service
 *
 * info user
 * GET -> uri + /users/{id}
 *
 * block user
 * (add)
 * POST -> uri + /users/{id}/order_blacklist?access_token={access_token}
 *      -> parameter: { user_id: id }
 * (list)
 * GET -> uri + /users/{id}/order_blacklist?access_token={access_token}
 * (remove)
 * DELETE -> uri + /users/{id}/order_blacklist/{user_id}?access_token={access_token}
 *
 */
class User
{
    private $meli;
    private $path = 'users';

    public function __construct()
    {
        $this->meli = \App::make('MeliUser');
    }

    public function get($id)
    {
        try {

            $request = $this->meli->get($this->path . '/' . $id);
            return (isset($request['body']) && !empty($request['body'])) ? $request['body'] : [];

        } catch (Exception $e) {
            return $e;
        }
    }

    public function block($id, $block)
    {
        try {

            return $this->meli->post(
                $this->path . '/' . $id . '/order_blacklist',
                array('user_id'=>$block)
            );

        } catch (Exception $e) {
            return $e;
        }
    }

    public function unlock($id, $blocked)
    {
        try {

            return $this->meli->delete($this->path . '/' . $id . '/order_blacklist/' . $blocked);

        } catch (Exception $e) {
            return $e;
        }
    }

    public function getBlocked($id)
    {
        try {

            $request = $this->meli->get($this->path . '/' . $id . '/order_blacklist');
            return (isset($request['body']) && !empty($request['body'])) ? $request['body'] : [];

        } catch (Exception $e) {
            return $e;
        }
    }

}
