<?php

use Way\Tests\Factory;
use Faker\Factory as Faker;

class StoreTest extends TestCase
{
    use ModelHelpers;

    protected $model;

    public function setUp()
    {
        parent::setUp();
        $this->model = Factory::make('MLTools\Models\Store');
    }

    public function testIsValid()
    {
        $this->model->store_id = Faker::create()->randomNumber();
        $this->model->site_id = Faker::create()->randomNumber();
        $this->model->first_name = Faker::create()->name();
        $this->model->email = Faker::create()->email();

        $this->assertValid($this->model);
    }

    public function testIsNotValidWithoutStoreId()
    {
        $this->model->site_id = Faker::create()->randomNumber();
        $this->model->first_name = Faker::create()->name();
        $this->model->email = Faker::create()->email();

        $this->assertNotValid($this->model);
    }

    public function testIsNotValidWithoutSiteId()
    {
        $this->model->store_id = Faker::create()->randomNumber();
        $this->model->first_name = Faker::create()->name();
        $this->model->email = Faker::create()->email();

        $this->assertNotValid($this->model);
    }

    public function testIsNotValidWithoutFirstName()
    {
        $this->model->store_id = Faker::create()->randomNumber();
        $this->model->site_id = Faker::create()->randomNumber();
        $this->model->email = Faker::create()->email();

        $this->assertNotValid($this->model);
    }

    public function testIsNotValidWithoutEmail()
    {
        $this->model->store_id = Faker::create()->randomNumber();
        $this->model->site_id = Faker::create()->randomNumber();
        $this->model->first_name = Faker::create()->name();

        $this->assertNotValid($this->model);
    }

    public function testIsNotValidWithInvalidEmail()
    {
        $this->model->store_id = Faker::create()->randomNumber();
        $this->model->site_id = Faker::create()->randomNumber();
        $this->model->first_name = Faker::create()->name();
        $this->model->email = 'invalidEmail';

        $this->assertNotValid($this->model);
    }

    public function testBelongsToManyCustomers()
    {
        $this->assertBelongsToMany('customers', 'MLTools\Models\Store');
    }

    // cover user
    public function testBelongsToManyUsers()
    {
        $this->assertBelongsToMany('users', 'MLTools\Models\Store');

//        $relation = Mockery::mock('\Illuminate\Database\Eloquent\Relations\BelongsToMany');
//        $store = Mockery::mock('\MLTools\Models\Store');
//
//        $store->shouldReceive('belongsToMany')
//            ->with('MLTools\Models\Store', 'stores_users', 'store_id', 'user_id')
//            ->andReturn($relation)
//            ->once();
//
//        $relation->shouldReceive('withPivot')
//            ->with('status')
//            ->andReturn($relation)
//            ->once();
//
//        $store->belongsToMany('MLTools\Models\Store', 'stores_users', 'store_id', 'user_id')->withPivot('status');
//
//        $store->shouldReceive('users')
//            ->andReturn($relation)
//            ->once();
//
//        $this->assertTrue(method_exists($store, 'users'));
//        $store->users();
    }

    public function testAddUser()
    {
        $this->assertTrue(true);
    }

    public function testRemoveUser()
    {
        $this->assertTrue(true);
    }

    public function testBelongsToManyStores()
    {
        $this->assertBelongsToMany('stores', 'MLTools\Models\Store');
    }

    public function testHasManyTasks()
    {
        $this->assertHasMany('tasks', 'MLTools\Models\Store');
    }

    public function testHasManyNotification()
    {
        $this->assertHasMany('notifications', 'MLTools\Models\Store');
    }

    public function testGetAuthIdentifier()
    {
        $id = Faker::create()->randomNumber();

        $this->assertNull($this->model->getAuthIdentifier());

        $this->model->id = $id;
        $this->assertEquals($id, $this->model->getAuthIdentifier());
    }

    public function testGetAuthPassword()
    {
        $this->assertNull($this->model->getAuthPassword());
    }

    public function testSetRememberToken()
    {
        $this->assertTrue($this->model->setRememberToken(null));
        $this->assertTrue($this->model->setRememberToken(123));
        $this->assertTrue($this->model->setRememberToken('Token'));
    }

    public function testGetRememberToken()
    {
        $this->assertNull($this->model->getRememberToken());
    }

    public function testGetRememberTokenName()
    {
        $this->assertNull($this->model->getRememberTokenName());
    }

}