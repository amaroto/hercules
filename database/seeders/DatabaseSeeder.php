<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create();
        \App\Models\Company::factory(10)->create();
        \App\Models\Lead::factory(10)->create();
        \App\Models\Client::factory(10)->create();

        DB::table('users')->insert([
            'username' => 'admin',
            'firstname' => 'admin',
            'lastname' => 'admin',
            'email' => 'admin@admin.com',
            'email_verified_at' => '2021-01-01 01:00:00',
            'password' => Hash::make('password'),
            'active' => 1
        ]);
    }
}
