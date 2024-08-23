<?php

namespace Database\Seeders;

use App\Models\Userss;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserssSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Userss::factory(5)->create();
    }
}
