<?php

namespace MLTools\Http\Controllers;

use Illuminate\Http\Request;
use MLTools\Contracts\IAdvertRepository;

class AdvertController extends Controller
{

    private $repository;

    public function __construct(IAdvertRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $user = $request->user();

        return response()->json($this->repository->findByStore($user)->toArray());
    }

}