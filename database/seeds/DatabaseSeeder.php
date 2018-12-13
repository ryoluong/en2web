<?php

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
        // $this->call(FirstUsersSeeder::class);
        // $this->call(SecondUsersSeeder::class);
        // $this->call(ThirdUsersSeeder::class);
        // $this->call(TagsTableSeeder::class);
        // $this->call(CountriesTableSeeder::class);
        // $this->call(CategoriesTableSeeder::class);
         $this->call(CodesTableSeeder::class);
    }
}