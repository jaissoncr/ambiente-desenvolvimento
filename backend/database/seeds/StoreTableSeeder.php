<?php

use Illuminate\Database\Seeder;

class StoreTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stores')->insert([
            'store_id' => rand(),
            'site_id' => 'MLB',
			'first_name' => str_random(10),
            'last_name' => str_random(20),
            'nickname' => str_random(15),
            'email' => str_random(10).'@gmail.com',
        ]);
    }
}
