<?php

use Illuminate\Database\Seeder;

class SecondUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            'Satoko Oda',
            'Naotaka Nishikawa',
            'Kanna Ichiyanagi',
            'Takuro Umihara',
            'Seiya Tajima',
            'Tomoko Kanno',
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
                'generation' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ];
            DB::table('users')->insert($user);
        }
    }
}
