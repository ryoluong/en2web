<?php

use Illuminate\Database\Seeder;

class FourthUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            'Ryohei Takahashi',
            'Mei Mishina',
            'Daisuke Kikuchi',
            'Ayaho Tsunematsu',
            'Seiho Shindo',
            'Erimo Taniguchi',
            'Kiyoka Ebina',
            'Toshie Go'
        ];
        // foreach ($tags as $tag) {
        //     DB::table('tags')->insert('tag');
        // }
        $now = \Carbon\Carbon::now();
        
        for ($i = 0; $i < count($users); $i++) {
                $user = [
                    'name' => $users[$i],
                    'identification_code' => str_random(12),
                    'status' => 3,
                    'generation' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            
            DB::table('users')->insert($user);
        }
    }
}
