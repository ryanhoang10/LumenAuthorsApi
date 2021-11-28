<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // creating 30 fake entries to the Author table
        \App\Models\Author::factory()->count(30)->create();   
    }
}
