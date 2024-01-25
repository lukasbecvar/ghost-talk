<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // call other seeders here
        $this->call(UserSeeder::class);
    }
}
