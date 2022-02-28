<?php

namespace Database\Seeders;

use App\Classes\StorePopularScreenplays;
use App\Models\Diary;
use App\Models\Movie;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
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
    public function run()
    {
        $demoUser = User::firstOrCreate(
            ['email' => 'demo@demo.demo'],
            [
                'name' => 'demo user',
                'password' => Hash::make('@demo-password@'),
                'email_verified_at' => now(),
            ],
        );

        event(new Verified($demoUser));

        (new StorePopularScreenplays())();
    }
}
