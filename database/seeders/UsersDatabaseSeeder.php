<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersDatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();


        DB::table('users')->insert([
            'id'                => 1,
            'name'              => 'admin' ,
            'email'             => 'user@user.com',
            'email_verified_at' => now(),
            'password'          => Hash::make('123456'),
            'remember_token'    => Str::random(10),
        ]);


        for ($i = 1; $i <= 5; $i++) {
            DB::table('users')->insert([
                'id'                => $i + 1,
                'name'              => 'user' . $i,
                'email'             => 'user' . $i . '@user.com',
                'email_verified_at' => now(),
                'password'          => Hash::make('123456'),
                'remember_token'    => Str::random(10),
            ]);
        }
    }
}
