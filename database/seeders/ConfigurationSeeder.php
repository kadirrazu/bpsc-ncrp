<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class ConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('configs')->insert(
            [
                [
                    'key' => 'negative_mark', 
                    'value' => '0', 
                    'remarks' => 'Set negative mark value. Set 0 for excluding negative marks.', 
                    'created_at' => Carbon::now(), 
                    'updated_at' => Carbon::now() 
                ],
                [
                    'key' => 'set1_extra_mark', 
                    'value' => '0', 
                    'remarks' => 'Set extra mark for set 1 candidates, if applicable.', 
                    'created_at' => Carbon::now(), 
                    'updated_at' => Carbon::now() 
                ],
                [
                    'key' => 'set2_extra_mark', 
                    'value' => '0', 
                    'remarks' => 'Set extra mark for set 2 candidates, if applicable.', 
                    'created_at' => Carbon::now(), 
                    'updated_at' => Carbon::now() 
                ],
                [
                    'key' => 'set3_extra_mark', 
                    'value' => '0', 
                    'remarks' => 'Set extra mark for set 3 candidates, if applicable.', 
                    'created_at' => Carbon::now(), 
                    'updated_at' => Carbon::now() 
                ],
                [
                    'key' => 'set4_extra_mark', 
                    'value' => '0', 
                    'remarks' => 'Set extra mark for set 4 candidates, if applicable.', 
                    'created_at' => Carbon::now(), 
                    'updated_at' => Carbon::now() 
                ],
                [
                    'key' => 'invalidate_fillup_error', 
                    'value' => '1', 
                    'remarks' => '1 for making invalid, 0 for valid.', 
                    'created_at' => Carbon::now(), 
                    'updated_at' => Carbon::now() 
                ],
        ]);
    }
}
