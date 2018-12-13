<?php

use Illuminate\Database\Seeder;

class FirstUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            'Genki Yonetani',
            'Wataru Ogasawara',
            'Kyoichi Ishii',
            'Hirokazu Orui',
            'Haruna Fukushima',
            'Sayaka Iwazumi',
            'Chihiro Hosokawa',
            'Suzuka Nakagawa',
            'Momoka Kuniyuki',
            'Ryo Kobayashi',
            'Sayaka Sakurai',
            'Rika Nakano',
            'Kenshiro Kishida',
            'Taisuke Suzuki',
            'Maria Shikai',
        ];
        // foreach ($tags as $tag) {
        //     DB::table('tags')->insert('tag');
        // }
        $now = \Carbon\Carbon::now();
        
        for ($i = 0; $i < count($users); $i++) {
            if($user[$i] == 'Ryo Kobayashi')
            {
                $user = [
                    'name' => $users[$i],
                    'identification_code' => str_random(12),
                    'status' => 3,
                    'generation' => 1,
                    'isAdmin' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            } else {
                $user = [
                    'name' => $users[$i],
                    'identification_code' => str_random(12),
                    'status' => 3,
                    'generation' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
            DB::table('users')->insert($user);
        }
    }
}
