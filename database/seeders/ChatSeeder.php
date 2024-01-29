<?php

namespace Database\Seeders;

use Database\Factories\ChatFactory;
use Illuminate\Database\Seeder;

class ChatSeeder extends Seeder
{
    public function run(): void
    {
        ChatFactory::new()->count(10)->create();
    }
}
