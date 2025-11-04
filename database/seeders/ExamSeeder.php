<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class ExamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('exams')->insert(
            [
                'authority' => 'Bangladesh Public Service Commission (BPSC)',
                'entity' => 'Election Commission Secretariat',
                'post_code' => 250045,
                'post_name' => 'Upazila Election Officer',
                'grade' => 9,
                'type' => 'Preliminary (MCQ)',
                'exam_date' => '2025-11-23',
                'rp_date' => '2025-11-25',
                'total_candidate' => 148765,
                'present_candidate' => 89640,
                'rp_status' => 'Ongoing',
                'is_current' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
        ]);
    }
}
