<?php

use Illuminate\Database\Seeder;
use App\Admin;
use App\Client;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $email = config('site.email');

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
