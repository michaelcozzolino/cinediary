<?php

namespace Database\Seeders;

use App\Classes\StorePopularScreenplays;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function __construct(protected StorePopularScreenplays $storePopularScreenplays)
    {
    }

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

        /** TODO: to be refactored */
//          (new StorePopularScreenplays())();
    }
}
