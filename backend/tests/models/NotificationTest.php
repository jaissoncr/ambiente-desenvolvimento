<?php

use Way\Tests\Factory;
use Faker\Factory as Faker;

class NotificationTest extends TestCase
{
    use ModelHelpers;

    public function setUp()
    {
        parent::setUp();
        $this->model = Factory::make('MLTools\Models\Notification');
    }

    public function testIsValid()
    {
        $this->model->user_id = Faker::create()->randomNumber();
        $this->model->resource = '\/items\/MLB101010';
        $this->model->topic = 'items';
        $this->model->received = Faker::create()->iso8601();
        $this->model->sent = Faker::create()->iso8601();
        $this->assertValid($this->model);
    }

    public function testIsNotValidWithoutUserId()
    {
        $this->model->user_id = null;
        $this->model->resource = '\/items\/MLB101010';
        $this->model->topic = 'items';
        $this->model->received = Faker::create()->iso8601();
        $this->model->sent = Faker::create()->iso8601();
        $this->assertNotValid($this->model);
    }

    public function testIsNotValidWithoutResource()
    {
        $this->model->user_id = Faker::create()->randomNumber();
        $this->model->resource = null;
        $this->model->topic = 'items';
        $this->model->received = Faker::create()->iso8601();
        $this->model->sent = Faker::create()->iso8601();
        $this->assertNotValid($this->model);
    }

    public function testIsNotValidWithoutTopic()
    {
        $this->model->user_id = Faker::create()->randomNumber();
        $this->model->resource = '\/items\/MLB101010';
        $this->model->topic = null;
        $this->model->received = Faker::create()->iso8601();
        $this->model->sent = Faker::create()->iso8601();
        $this->assertNotValid($this->model);
    }

    public function testIsNotValidWithoutReceived()
    {
        $this->model->user_id = Faker::create()->randomNumber();
        $this->model->resource = '\/items\/MLB101010';
        $this->model->topic = 'items';
        $this->model->received = null;
        $this->model->sent = Faker::create()->iso8601();
        $this->assertNotValid($this->model);
    }

    public function testIsNotValidWithoutSent()
    {
        $this->model->user_id = Faker::create()->randomNumber();
        $this->model->resource = '\/items\/MLB101010';
        $this->model->topic = 'items';
        $this->model->received = Faker::create()->iso8601();
        $this->model->sent = null;
        $this->assertNotValid($this->model);
    }

    public function testBelongsToStore()
    {
        $this->assertBelongsTo('store', 'MLTools\Models\Notification');
    }

}