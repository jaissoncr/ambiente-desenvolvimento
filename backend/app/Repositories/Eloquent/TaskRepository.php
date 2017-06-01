<?php

namespace MLTools\Repositories\Eloquent;

use MLTools\Contracts\ITaskRepository;
use MLTools\Models\Task;
use MLTools\Models\Store;

class TaskRepository implements ITaskRepository
{

    private $model;

    public function __construct(Task $model)
    {
        $this->model = $model;
    }

    public function findByStore(Store $user)
    {
        return $user->tasks()
            ->select('id', 'store_id', 'title', 'completed')
            ->get();
    }

    public function create(array $data)
    {
        if (isset($data['title']))
            $this->model->title = $data['title'];

        if (isset($data['store_id']))
            $this->model->store_id = $data['store_id'];

        return ($this->model->validate()) ? $this->model->create($data) : $this->model->errors->getMessages();
    }

    public function update(array $data, $id)
    {
        $get = $this->model->find($id);

        if (isset($data['title']))
            $get->title = $data['title'];

        /** TODO Lançar exception */
        return ($get->validate()) ? $get->update($data) : false;
    }

    public function markAll(Store $user, $completed)
    {
        return $user->tasks()
            ->where('store_id', $user->store_id)
            ->where('completed', false)
            ->update(['completed' => $completed]);
    }

    public function delete($id)
    {
        return $this->model
            ->find($id)
            ->delete();
    }

    public function deleteByStore(Store $user)
    {
        return $user->tasks()
            ->where('store_id', $user->store_id)
            ->delete();
    }

    public function deleteCompletedByStore(Store $user)
    {
        return $user->tasks()
            ->where('store_id', $user->store_id)
            ->where('completed', true)
            ->delete();
    }

}