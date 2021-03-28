<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name'              => 'Fabio Messias Dias',
                'email'             => 'mfabiodias@gmail.com',
                'username'          => 'mfabiodias',
                'email_verified_at' => now(),
                'password'          => '$2y$12$O1yxVAI2K46N0edf1x18leAKFZm7Y1KuP0CENlPcN7t6R7CJjqLhi',
                'remember_token'    => Str::random(10),
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            [
                'name'              => 'Keller Yorinori Souza',
                'email'             => 'kellerys@gmail.com',
                'username'          => 'kellerys',
                'email_verified_at' => now(),
                'password'          => '$2y$10$O38jFdPcnGMNAlSkyVogI.yvl0z6IEoCnMvbownj/7hR7rdzNDbq.',
                'remember_token'    => Str::random(10),
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
        ]);
    }
}