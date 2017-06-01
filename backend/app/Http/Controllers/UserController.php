<?php

namespace MLTools\Http\Controllers;

use Illuminate\Http\Request;
use MLTools\Contracts\IUserRepository;
use Auth;

class UserController extends Controller
{

    private $repository;

    public function __construct(IUserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        return $this->repository->findUsersByStore(Auth::user());
    }

    public function store(Request $request)
    {
        return $this->repository->addUser(Auth::user(), $request->input('id'));
    }

    public function block(Request $request)
    {
        return $this->repository->block(Auth::user(), $request->input('id'));
    }

    public function unlock($blocked)
    {
        return $this->repository->unlock(Auth::user(), $blocked);
    }

}
