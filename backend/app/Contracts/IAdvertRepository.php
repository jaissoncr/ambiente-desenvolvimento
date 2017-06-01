<?php

namespace MLTools\Contracts;

interface IAdvertRepository
{
    public function findOrCreate(array $data);
    public function findByStore(\MLTools\Models\Store $user);
}