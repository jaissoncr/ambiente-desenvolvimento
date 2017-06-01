<?php

namespace MLTools\Contracts;

interface IUserRepository
{
    public function findByIdOrCreate($userData);
    public function checkIfUserNeedsUpdating($userData, $user);
    public function findUsersByStore(\MLTools\Models\Store $user);
    public function findMeliUserById($id);
    public function addUser(\MLTools\Models\Store $user, $id);
    public function removeUser(\MLTools\Models\Store $user, $id);
    public function block(\MLTools\Models\Store $user, $block);
    public function unlock(\MLTools\Models\Store $user, $blocked);
}