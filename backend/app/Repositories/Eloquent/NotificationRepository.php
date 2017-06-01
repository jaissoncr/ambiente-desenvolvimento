<?php

namespace MLTools\Repositories\Eloquent;


use MLTools\Contracts\INotificationRepository;
use MLTools\Models\Notification;

class NotificationRepository implements INotificationRepository
{
    private $model;

    public function __construct(Notification $model)
    {
        $this->model = $model;
    }

    public function create(array $data)
    {
        $this->model = new $this->model($data);
        if (!$this->model->validate()) {
            return [
                'status' => 'error',
                'message' => $this->model->errors->getMessages(),
                'data' => 'CadastroInválido'
            ];
        }

        return [
            'status' => 'success',
            'data' => $this->model->create($data),
        ];
    }

    public function find($id)
    {
        return $this->model->find($id);
    }
}