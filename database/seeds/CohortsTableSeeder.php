<?php

use Illuminate\Database\Seeder;
use App\Models\Cohort;
use Carbon\Carbon;

class CohortsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cohorts = [
            [
                'name' => 'الفوج الأول: دفعة نوفمبر 25',
                'description' => 'الفوج الأول من سبتمبر إلى نوفمبر 2025',
                'start_date' => Carbon::create(2025, 9, 1),
                'end_date' => Carbon::create(2025, 11, 30),
                'max_trainees' => 18,
                'status' => 1,
            ],
            [
                'name' => 'الفوج الثاني: دفعة فبراير 26',
                'description' => 'الفوج الثاني من نوفمبر إلى فبراير 2026',
                'start_date' => Carbon::create(2025, 12, 1),
                'end_date' => Carbon::create(2026, 2, 28),
                'max_trainees' => 18,
                'status' => 1,
            ],
            [
                'name' => 'الفوج الثالث: دفعة يونيو 26',
                'description' => 'الفوج الثالث من أبريل إلى يونيو 2026',
                'start_date' => Carbon::create(2026, 4, 1),
                'end_date' => Carbon::create(2026, 6, 30),
                'max_trainees' => 18,
                'status' => 1,
            ],
            [
                'name' => 'الفوج الرابع: دفعة نوفمبر 26',
                'description' => 'الفوج الرابع من سبتمبر إلى نوفمبر 2026',
                'start_date' => Carbon::create(2026, 9, 1),
                'end_date' => Carbon::create(2026, 11, 30),
                'max_trainees' => 18,
                'status' => 1,
            ],
            [
                'name' => 'الفوج الخامس: دفعة فبراير 27',
                'description' => 'الفوج الخامس من نوفمبر إلى فبراير 2027',
                'start_date' => Carbon::create(2026, 12, 1),
                'end_date' => Carbon::create(2027, 2, 28),
                'max_trainees' => 18,
                'status' => 1,
            ],
            [
                'name' => 'الفوج السادس: دفعة يونيو 27',
                'description' => 'الفوج السادس من أبريل إلى يونيو 2027',
                'start_date' => Carbon::create(2027, 4, 1),
                'end_date' => Carbon::create(2027, 6, 30),
                'max_trainees' => 18,
                'status' => 1,
            ],
        ];

        foreach ($cohorts as $cohort) {
            Cohort::create($cohort);
        }
    }
}
