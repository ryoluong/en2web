<?php

use Illuminate\Database\Seeder;

class CodesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 100; $i++) {
            $code = [
                'code' => str_random(12),
            ];
            DB::table('codes')->insert($code);
        }
    }
}