<?php

namespace Database\Seeders;

use Database\Factories\ConnectionFactory;
use Illuminate\Database\Seeder;

class ConnectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        ConnectionFactory::new()->count(10)->create();
    }
}
