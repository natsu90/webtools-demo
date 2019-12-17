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
        DB::table('users')->insert([
            'name' => 'ADMIN',
            'username' => 'admin',
            'email' => Str::random(10).'@gmail.com',
            'password' => bcrypt('password'),
        ]);
    }
}
