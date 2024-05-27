<?php

namespace Database\Seeders;

use App\Models\Testdb;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestdbSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Testdb::create([
            'test'=>0
        ]);
    }
}
