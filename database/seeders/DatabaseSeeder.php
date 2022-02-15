<?php

namespace Database\Seeders;

use App\Classes\StorePopularScreenplays;
use App\Models\Diary;
use App\Models\Movie;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {

//         $movies = Movie::factory(100)->create();
//         $user = User::find(1);
//         $diaries = $user->diaries()->get();
//
//         foreach ($movies as $movie){
//             $randomDiary = $diaries[rand(0, count($diaries) - 1)];
//             $randomDiary->movies()->attach($movie->id);
//         }

        //INSERT INTO cinediary.users (id, name, email, email_verified_at, password, remember_token, created_at, updated_at)
        // VALUES (1, 'mike', 'emc2@outlook.it', null,
        // '$2y$10$j/3yigmfgZTv5HScdIclSeIOIV2900Fj3zjoCp7YbLvY02cWZ42p2',
        // 'LiwOjKJSKeT8QLLXWoFCbQBZikEqrMZvNCvD09ros1SyUPOi7tf6hXwOJ4Tb', '2021-12-28 17:06:01', '2021-12-28 17:06:01');


        $demoUser = User::firstOrCreate(['email' => 'demo@demo.demo'], [
            'name' => 'demo user',

            'password' => Hash::make('@demo-password@'),
        ]);

        $user1 = User::firstOrCreate(['email' => 'emc2@outlook.it'],[
            'name' => 'mike',

            'password' => '$2y$10$j/3yigmfgZTv5HScdIclSeIOIV2900Fj3zjoCp7YbLvY02cWZ42p2',
        ]);

        $user2 = User::firstOrCreate(['email' => 'emc222@outlook.it'], [
            'name' => 'mike',
            'email' => 'emc222@outlook.it',
            'password' => '$2y$10$j/3yigmfgZTv5HScdIclSeIOIV2900Fj3zjoCp7YbLvY02cWZ42p2',
        ]);

        $users = [$demoUser, $user1, $user2];

        $diaryNames  = ['watched','favourite','to watch'];


        foreach ($users as $user) {
            foreach ($diaryNames as $diaryName) {
                Diary::firstOrCreate( [
                    'isMain' => 1,
                    'user_id' => $user->id,
                    'name' => $diaryName,

                ]);
            }

            Setting::firstOrCreate([
                'user_id' => $user->id,
            ]);
        }


        (new StorePopularScreenplays)();

    }
}
