<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\SON\User::class, 1)->create([
            'email' => 'admin@schoolofnet.com'
        ]);
        factory(\SON\User::class, 20)->create();
    }
}
