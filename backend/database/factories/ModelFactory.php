<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(MLTools\User::class, function ($faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => str_random(10),
        'remember_token' => str_random(10),
    ];
});

$factory->define(MLTools\Models\Store::class, function($faker) {
    return [
        'store_id' => $faker->randomNumber(),
        'site_id' => $faker->randomNumber(),
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'nickname' => $faker->name,
        'email' => $faker->email,
    ];
});

$factory->define(MLTools\Models\Notification::class, function($faker){
    return [
        'user_id' => $faker->randomNumber(),
        'resource' => '\/items\/MLB123123',
        'topic' => 'items',
        'received' => $faker->iso8601,
        'sent' => $faker->iso8601,
    ];
});