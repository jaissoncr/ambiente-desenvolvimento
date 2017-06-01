<?php

use \Way\Tests\Factory;
use Faker\Factory as Faker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TaskControllerTest extends TestCaseController
{
    use DatabaseMigrations;

    protected $server;
    protected $repository;

    public function setUp()
    {
        parent::setUp();

        $this->server = [
            'HTTP_X-Requested-With' => 'XMLHttpRequest',
            'HTTP_CONTENT_TYPE', 'application/json',
            'HTTP_ACCEPT', 'application/json',
        ];

        $this->repository = new \MLTools\Repositories\Eloquent\TaskRepository(new \MLTools\Models\Task);
    }

    public function testIndexAjaxAccessWithoutLogin()
    {
        $this->call('GET', '/tarefas', [], [], [], $this->server);

        $this->assertResponseStatus(401);
    }

    public function testIndexNormalAccessWithoutLogin()
    {
        $this->call('GET', '/tarefas');

        $this->assertResponseStatus(302);

        $this->assertRedirectedTo('/info');
    }

    public function testIndexEmpty()
    {
        $store1 = factory(MLTools\Models\Store::class)->create();
        $store2 = factory(MLTools\Models\Store::class)->create();

        $this->be($store1);
        $this->get('/tarefas')
            ->seeJson([]);

        $this->be($store2);
        $this->get('/tarefas')
            ->seeJson([]);
    }

    public function testIndexWithTwoUsers()
    {
        /** Criação de usuários */
        $store1 = factory(MLTools\Models\Store::class)->create();
        $store2 = factory(MLTools\Models\Store::class)->create();

        /** Login usuário 1 */
        $this->be($store1);

        /** Criação de tasks para o usuário 1 */
        $task1 = [
            'store_id' => "".$store1->store_id,
            'title' => Faker::create()->text(),
        ];
        $task2 = [
            'store_id' => "".$store1->store_id,
            'title' => Faker::create()->text(),
        ];

        $t1 = $this->repository->create($task1);
        $t2 = $this->repository->create($task2);

        $task1['id'] = "".$t1->id;
        $task2['id'] = "".$t2->id;

        /** Verifica se retorna as tasks corretas para o usuário 1 */
        $this->get('/tarefas')->seeJsonContains($task1);
        $this->get('/tarefas')->seeJsonContains($task2);

        /** Login usuário 2 */
        $this->be($store2);

        /** Verifica se a consulta não retorna tasks */
        $this->get('/tarefas')
            ->seeJson([]);

        /** Adiciona taks para o usuário 2 */
        $task3 = [
            'store_id' => "".$store2->store_id,
            'title' => Faker::create()->text(),
        ];
        $t3 = $this->repository->create($task3);
        $task3['id'] = "".$t3->id;

        /** Verifica se retorna a task recém criada */
        $this->get('/tarefas')->seeJsonContains($task3);

        /** Verifica se a task do usuário 1 não aparece para o usuário 2 */
        $this->get('/tarefas')->seeJsonContains($task2, true);
    }

    public function testStoreValid()
    {
        /** Criação de usuários */
        $store = factory(MLTools\Models\Store::class)->create();

        /** Login */
        $this->be($store);

        /** Task */
        $task = [
            'title' => Faker::create()->text(),
        ];

        $this->post('/tarefas', $task)
            ->seeJsonContains(array_merge($task, ['store_id' => $store->store_id]));
    }

    public function testStoreNotValidWithoutTitle()
    {
        /** Criação de usuários */
        $store = factory(MLTools\Models\Store::class)->create();

        /** Login */
        $this->be($store);

        /** Task */
        $task = [
            'title' => "",
        ];

        $this->post('/tarefas', $task)
            ->seeJsonContains(array_merge($task, ['store_id' => $store->store_id]), true);
    }

    public function testStoreNotValidWithoutUser()
    {
        /** Task */
        $task = [
            'title' => Faker::create()->text(),
        ];

        $this->post('/tarefas', $task);

        $this->assertResponseStatus(302);
    }

    public function testDeleteSuccess()
    {
        /** Retorno esperado */
        $expected = ['result' => 1, 'message' => 'Tarefa removida com sucesso!'];

        /** User */
        $store = factory(MLTools\Models\Store::class)->create();

        /** Login */
        $this->be($store);

        /** Task */
        $task = [
            'store_id' => $store->store_id,
            'title' => Faker::create()->text(),
        ];
        $taskCreated = $this->repository->create($task);

        /** Delete */
        $this->delete('/tarefas/' . $taskCreated->id)
            ->seeJsonContains($expected);

        /** Verifica se realmente removeu */
        $this->get('/tarefas')
            ->seeJson([]);
    }

    public function testDeleteFailWithoutId()
    {
        /** Retorno esperado */
        $expected = ['result' => 0, 'message' => 'ID não informado.'];

        /** User */
        $store = factory(MLTools\Models\Store::class)->create();

        /** Login */
        $this->be($store);

        /** Delete */
        $this->delete('/tarefas');
        $this->assertResponseStatus(405);
    }

    public function testDeleteFailNotExists()
    {
        /** Retorno esperado */
        $expected = ['result' => 0, 'message' => 'ID inválido.'];

        /** User */
        $store = factory(MLTools\Models\Store::class)->create();

        /** Login */
        $this->be($store);

        /** Delete */
        $this->delete('/tarefas/0')
            ->seeJsonContains($expected);

        $this->delete('/tarefas/999')
            ->seeJsonContains($expected);
    }

    public function testDeleteFailNotOwner()
    {
        /** User */
        $store1 = factory(MLTools\Models\Store::class)->create();
        $store2 = factory(MLTools\Models\Store::class)->create();

        /** Login User1 */
        $this->be($store1);

        /** Task */
        $task = [
            'store_id' => $store1->store_id,
            'title' => Faker::create()->text(),
        ];
        $task1Created = $this->repository->create($task);

        /** Login User2 */
        $this->be($store2);

        /** Task */
        $task = [
            'store_id' => $store2->store_id,
            'title' => Faker::create()->text(),
        ];
        $task2Created = $this->repository->create($task);

        /** Delete ok */
        $this->delete('/tarefas/' . $task1Created->id)
            ->seeJsonContains(['result' => 0, 'message' => 'ID inválido.']);

        /** Delete fail */
        $this->delete('/tarefas/' . $task2Created->id)
            ->seeJsonContains(['result' => 1, 'message' => 'Tarefa removida com sucesso!']);

        /** Verifica se realmente removeu */
        $this->get('/tarefas')
            ->seeJson([]);
    }

    public function testDeleteAllSuccess()
    {
        /** Retorno esperado */
        $expected = ['result' => 1, 'message' => 'Tarefas removidas com sucesso!'];

        /** User */
        $store = factory(MLTools\Models\Store::class)->create();

        /** Login */
        $this->be($store);

        /** Task */
        $task1 = [
            'store_id' => $store->store_id,
            'title' => Faker::create()->text(),
        ];
        $task1Created = $this->repository->create($task1);
        $task2 = [
            'store_id' => $store->store_id,
            'title' => Faker::create()->text(),
        ];
        $task2Created = $this->repository->create($task2);

        /** Delete */
        $this->delete('/tarefas/all')
            ->seeJsonContains($expected);

        /** Verifica se realmente removeu */
        $this->get('/tarefas')
            ->seeJson([]);
    }

    public function testUpdateSuccess()
    {
        /** User */
        $store = factory(MLTools\Models\Store::class)->create();

        /** Login */
        $this->be($store);

        /** Task */
        $task = [
            'store_id' => "" . $store->store_id,
            'title' => Faker::create()->text(),
        ];
        $taskCreated = $this->repository->create($task);
        $task['id'] = "" . $taskCreated->id;

        $this->get('/tarefas')
            ->seeJsonContains($task);

        $task['title'] = Faker::create()->text();
        $this->put('/tarefas/' . $taskCreated->id, ['title' => $task['title']])
            ->seeJsonContains(['result' => 1, 'message' => 'Tarefa atualizada com sucesso!']);

        $this->get('/tarefas')
            ->seeJsonContains($task);
    }

    public function testUpdateFail()
    {
        /** User */
        $store = factory(MLTools\Models\Store::class)->create();

        /** Login */
        $this->be($store);

        /** Task */
        $task = [
            'store_id' => "" . $store->store_id,
            'title' => Faker::create()->text(),
        ];
        $taskCreated = $this->repository->create($task);
        $task['id'] = "" . $taskCreated->id;

        $this->get('/tarefas')
            ->seeJsonContains($task);

        $this->put('/tarefas/' . $taskCreated->id, ['title' => ""])
            ->seeJsonContains(['result' => 0, 'message' => 'Erro ao atualizar tarefa.']);

        $this->get('/tarefas')
            ->seeJsonContains($task);
    }

}