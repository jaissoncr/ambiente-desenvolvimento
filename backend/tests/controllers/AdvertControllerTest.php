<?php

use \Illuminate\Foundation\Testing\DatabaseMigrations;

class AdvertControllerTest extends TestCaseController
{
    use DatabaseMigrations;

    public function testIndexRoute()
    {
        /** Login */
        $store = factory(MLTools\Models\Store::class)->create();
        $this->be($store);

        $this->get('/anuncios');

        $this->assertResponseStatus(200);
    }

}