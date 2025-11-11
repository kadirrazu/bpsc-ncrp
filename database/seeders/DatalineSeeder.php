<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class DatalineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('datalines')->insert(
            [
                [
                    'script_type' => 'e_type', 
                    'part_title' => 'scan_sr', 
                    'part_sequence' => 1, 
                    'length' => 10, 
                    'created_at' => Carbon::now(), 
                    'updated_at' => Carbon::now() 
                ],
                [
                    'script_type' => 'e_type', 
                    'part_title' => 'litho_code1', 
                    'part_sequence' => 2, 
                    'length' => 31, 
                    'created_at' => Carbon::now(), 
                    'updated_at' => Carbon::now() 
                ],
                [
                    'script_type' => 'e_type', 
                    'part_title' => 'center', 
                    'part_sequence' => 3, 
                    'length' => 1, 
                    'created_at' => Carbon::now(), 
                    'updated_at' => Carbon::now() 
                ],
                [
                    'script_type' => 'e_type', 
                    'part_title' => 'reg_number', 
                    'part_sequence' => 4, 
                    'length' => 6, 
                    'created_at' => Carbon::now(), 
                    'updated_at' => Carbon::now() 
                ],
                [
                    'script_type' => 'e_type', 
                    'part_title' => 'set_code', 
                    'part_sequence' => 5, 
                    'length' => 1, 
                    'created_at' => Carbon::now(), 
                    'updated_at' => Carbon::now() 
                ],
                [ 
                    'script_type' => 'e_type', 
                    'part_title' => 'litho_code2', 
                    'part_sequence' => 6, 
                    'length' => 31, 
                    'created_at' => Carbon::now(), 
                    'updated_at' => Carbon::now() 
                ],
                [
                    'script_type' => 'e_type', 
                    'part_title' => 'bullet', 
                    'part_sequence' => 7, 
                    'length' => 9, 
                    'created_at' => Carbon::now(), 
                    'updated_at' => Carbon::now() 
                ],
                [
                    'script_type' => 'e_type', 
                    'part_title' => 'litho_direction', 
                    'part_sequence' => 1, 
                    'length' => 1, 
                    'created_at' => Carbon::now(), 
                    'updated_at' => Carbon::now() 
                ],
        ]);

        DB::table('datalines')->insert(
            [
                [
                    'script_type' => 'h_type', 
                    'part_title' => 'scan_sr', 
                    'part_sequence' => 1, 
                    'length' => 10, 
                    'created_at' => Carbon::now(), 
                    'updated_at' => Carbon::now() 
                ],
                [
                    'script_type' => 'h_type', 
                    'part_title' => 'litho_code1', 
                    'part_sequence' => 2, 
                    'length' => 31, 
                    'created_at' => Carbon::now(), 
                    'updated_at' => Carbon::now() 
                ],
                [
                    'script_type' => 'h_type', 
                    'part_title' => 'answers', 
                    'part_sequence' => 3, 
                    'length' => 100, 
                    'created_at' => Carbon::now(), 
                    'updated_at' => Carbon::now() 
                ],
                [
                    'script_type' => 'h_type', 
                    'part_title' => 'litho_code2', 
                    'part_sequence' => 4, 
                    'length' => 31, 
                    'created_at' => Carbon::now(), 
                    'updated_at' => Carbon::now() 
                ],
                [
                    'script_type' => 'h_type', 
                    'part_title' => 'bullet', 
                    'part_sequence' => 5, 
                    'length' => 9, 
                    'created_at' => Carbon::now(), 
                    'updated_at' => Carbon::now() 
                ],
                [
                    'script_type' => 'h_type', 
                    'part_title' => 'litho_direction', 
                    'part_sequence' => 1, 
                    'length' => 1, 
                    'created_at' => Carbon::now(), 
                    'updated_at' => Carbon::now() 
                ],
        ]);
    }
}
