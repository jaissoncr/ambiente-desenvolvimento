<?php

use Way\Tests\Factory;
use Faker\Factory as Faker;

class TaskTest extends TestCase
{
    use ModelHelpers;

    public function testIsValid()
    {
        $task = Factory::make('MLTools\Models\Task');

        $task->store_id = Faker::create()->randomNumber();
        $task->title = Faker::create()->text();
        $task->completed = Faker::create()->boolean(60);

        $this->assertValid($task);
    }

    public function testIsInvalidWithoutStoreId()
    {
        $task = Factory::make('MLTools\Models\Task');

        $task->title = Faker::create()->text();
        $task->completed = Faker::create()->boolean(60);

        $this->assertNotValid($task);
    }

    public function testIsInvalidWithoutDescription()
    {
        $task = Factory::make('MLTools\Models\Task');

        $task->store_id = Faker::create()->randomNumber();
        $task->completed = Faker::create()->boolean(60);

        $this->assertNotValid($task);
    }

    public function testBelongsToStore()
    {
        $this->assertBelongsTo('store', 'MLTools\Models\Task');
    }

}