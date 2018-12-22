<?php

use Illuminate\Database\Seeder;

class ThirdUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            'Yusaku Yanagawa',
            'Tomoki Shima',
            'Kojiro Aichi',
            'Souta Inoue',
            'Ryota Shinde',
            'Yuta Adachi',
            'Masashi Kato',
            'Kana Koizumi',
            'Momoka Kushida',
            'Kento Tawada',
            'Wataru Nakamura',
            'Yuzuki Kitayama',
            'Mana Odaka',
            'Kotaro Ariki',
            'Takahiro Matsumoto',
            'Yuki Yamamoto',
            'Hisashi Arai',
            'Yu Uchiya',
            'Haruna Sorita',
            'Ryota Onuma',
            'Takahiro Tomota',
            'Keishun Sakamoto',
            'Haruki Sasaki',
            'Yasuhiro Kai',
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
                'generation' => 3,
                'created_at' => $now,
                'updated_at' => $now,
            ];
            DB::table('users')->insert($user);
        }
    }
}
