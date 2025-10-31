<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('users')->insert(
            [
                'name' => 'Super Admin',
                'designation' => 'Super Admin',
                'email' => 'superadmin@bpsc.gov.bd',
                'password' => Hash::make('123456'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
        ]);

        DB::table('users')->insert(
            [
                'name' => 'Md. Abdul Kadir',
                'designation' => 'Programmer',
                'email' => 'kadir.bpsc@gmail.com',
                'password' => Hash::make('123456'),
                'profile_image' => '1.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
        ]);
        
        DB::table('users')->insert(
            [
                'name' => 'Md. Ashraful Islam',
                'designation' => 'System Analyst',
                'email' => 'sa2@bpsc.gov.bd',
                'password' => Hash::make('12345678'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
        ]);

        DB::table('users')->insert(
            [
                'name' => 'Md.Zohurul Islam',
                'designation' => 'Assistant Programmer',
                'email' => 'ap2@bpsc.gov.bd',
                'password' => Hash::make('12345678'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
        ]);

    }
}
