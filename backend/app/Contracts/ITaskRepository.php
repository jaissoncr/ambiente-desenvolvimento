<?php

namespace MLTools\Contracts;

interface ITaskRepository
{

    public function findByStore(\MLTools\Models\Store $user);
    public function create(array $data);
    public function update(array $data, $id);
    public function markAll(\MLTools\Models\Store $user, $completed);
    public function delete($id);
    public function deleteByStore(\MLTools\Models\Store $user);
    public function deleteCompletedByStore(\MLTools\Models\Store $user);

}