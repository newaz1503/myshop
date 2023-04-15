<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = DB::table('admins')->count();
        if ($count == 0) {
            DB::table('admins')->insert(
                [
                    [
                        'role_id'           => 1,
                        'name'              => 'Tushar Ahmed',
                        'username'          => 'tusharahmed',
                        'mobile'            => '0134567565',
                        'email'             => 'dev.tusharahmed@gmail.com',
                        'password'          => Hash::make('123456'),
                        'status'            => 'active',
                        'remember_token'    => Str::random(10),
                        'created_at'        => now(),
                        'updated_at'        => now(),
                    ],
                ]
            );
        }
    }
}
