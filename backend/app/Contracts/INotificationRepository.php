<?php

namespace MLTools\Contracts;


use Illuminate\Http\Request;

interface INotificationRepository
{
    public function create(array $data);
    public function find($id);
}