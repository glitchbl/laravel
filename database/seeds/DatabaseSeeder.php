<?php

use Illuminate\Database\Seeder;
use App\Admin;
use App\Client;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $email = config('app.email');

        Admin::create([
            'email' => $email,
            'password' => bcrypt('a'),
        ]);
        
        Client::create([
            'email' => $email,
            'password' => bcrypt('a'),
        ]);
    }
}
