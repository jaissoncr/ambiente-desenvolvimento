<?php

namespace MLTools\Http\Controllers;

use Illuminate\Http\Request;
use MLTools\Contracts\ITaskRepository;

class TaskController extends Controller
{

    private $repository;

    public function __construct(ITaskRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $user = $request->user();

        return response()->json($this->repository->findByStore($user)->toArray());
    }

    public function store(Request $request)
    {
        $user = $request->user();

        return response()->json($this->repository->create([
            'title'    => $request->input('title'),
            'store_id' => $user->store_id,
            'completed' => false,
        ]));
    }

    public function update(Request $request, $id)
    {
        $user = $request->user();

        if ($id == 'completed')
            return $this->markAll($request, true);

        if (!$user->tasks->find($id) && !empty($request->all()))
            return response()->json(['result' => 0, 'message' => 'ID inválido.']);

        return $this->repository->update($request->all(), $id) ?
            response()->json(['result' => 1, 'message' => 'Tarefa atualizada com sucesso!']) :
            response()->json(['result' => 0, 'message' => 'Erro ao atualizar tarefa.']);
    }

    public function markAll(Request $request, $completed)
    {
        $user = $request->user();

        return ($this->repository->markAll($user, $completed) > 0) ?
            response()->json(['result' => 1, 'message' => 'Tarefas atualizadas com sucesso!']) :
            response()->json(['result' => 0, 'message' => 'Erro ao atualizar tarefas.']);
    }

    public function destroy(Request $request, $id)
    {
        $user = $request->user();

        if ($id == 'all')
            return $this->destroyByStore($request);

        if ($id == 'completed')
            return $this->destroyCompletedByStore($request);

        $id = (int)$id;

        if (!$user->tasks->find($id))
            return response()->json(['result' => 0, 'message' => 'ID inválido.']);

        return ($this->repository->delete($id)) ?
            response()->json(['result' => 1, 'message' => 'Tarefa removida com sucesso!']) :
            response()->json(['result' => 0, 'message' => 'Erro ao remover tarefa.']);
    }

    public function destroyByStore(Request $request)
    {
        $user = $request->user();

        return ($this->repository->deleteByStore($user) > 0) ?
            response()->json(['result' => 1, 'message' => 'Tarefas removidas com sucesso!']) :
            response()->json(['result' => 0, 'message' => 'Não foram encontradas tarefas para o seu usuário. Atualize a página e verifique.']);
    }

    public function destroyCompletedByStore(Request $request)
    {
        $user = $request->user();

        return ($this->repository->deleteCompletedByStore($user) > 0) ?
            response()->json(['result' => 1, 'message' => 'Tarefas removidas com sucesso!']) :
            response()->json(['result' => 0, 'message' => 'Não foram encontradas tarefas concluídas para o seu usuário. Atualize a página e verifique novamente.']);
    }

}
