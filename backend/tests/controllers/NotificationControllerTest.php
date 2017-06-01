<?php

use \Illuminate\Foundation\Testing\DatabaseMigrations;

class NotificationControllerTest extends TestCaseController
{
    use DatabaseMigrations;

    public function testStoreRoute()
    {
        $this->post('/notificacoes', []);

        $this->assertResponseStatus(200);
    }

    public function testStore()
    {
        $notification = [
            'user_id' => '16627382',
            'resource' => '\/items\/MLB714266579',
            'topic' => 'items',
            'received' => '1977-01-05T09:42:19+0000',
            'sent' => '1999-05-09T00:34:09+0000',
        ];

        $this->post('/notificacoes', $notification)
            ->seeJsonContains(array_merge($notification, ['status' => 'success']));
    }

    public function testShowRoute()
    {
        $this->get('/notificacoes/1');

        $this->assertResponseStatus(200);
    }

    public function testStoreAndShow()
    {
        $notification = [
            'user_id' => '16627382',
            'resource' => '\/items\/MLB714266579',
            'topic' => 'items',
            'received' => '1977-01-05T09:42:19+0000',
            'sent' => '1999-05-09T00:34:09+0000',
        ];

        $this->post('/notificacoes', $notification)
            ->seeJsonContains(array_merge($notification, ['status' => 'success']));

        $this->get('/notificacoes/1')
            ->seeJsonContains($notification);
    }

}
