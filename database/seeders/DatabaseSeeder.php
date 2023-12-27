<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(ProductsTableSeeder::class);
        $this->call(Companies2TableSeeder::class);
        $this->call(SalesTableSeeder::class);
    }
}
