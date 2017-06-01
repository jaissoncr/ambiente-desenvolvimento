<?php

namespace MLTools\Http\Controllers;

use Illuminate\Http\Request;
use MLTools\Contracts\INotificationRepository;

class NotificationController extends Controller
{
    private $repository;

    public function __construct(INotificationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function store(Request $request)
    {
        $notification = $this->repository->create($request->input());

        if ($notification['status'] == 'success') {
            switch($notification['data']->topic) {
                case 'items':
                    $id = preg_replace('/.*([A-Z]{3}[\d]*).*/', "$1", $notification['data']->resource);
                    $this->dispatch(new \MLTools\Jobs\Meli\Item($id));
                    break;
            }
        }

        return response()->json($notification);
    }

    public function show($id)
    {
        return response()->json($this->repository->find($id));
    }

}