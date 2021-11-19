<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
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

        $role = Role::firstOrCreate(['name' => 'super']);
        $SuperAdmin = User::find(1);
        $SuperAdmin->assignRole($role->name);

        Permission::create(['name' => 'list-users']);
        Permission::create(['name' => 'list-permissions']);
        Permission::create(['name' => 'list-roles']);
        Permission::create(['name' => 'view-home']);
        Permission::create(['name' => 'view-dashboard']);
        Permission::create(['name' => 'view-Post']);
        Permission::create(['name' => 'upload-photo']);

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
