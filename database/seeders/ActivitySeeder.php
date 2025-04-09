<?php

namespace Database\Seeders;

use App\Models\Activity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ActivitySeeder extends Seeder
{
    public function run(): void
    {
        $statuses = ['Saved', 'Edit', 'Sent', 'Approve_by_province', 'Approve_by_central'];
        $titles = [
            'กิจกรรมสุขภาพ',
            'ปลูกต้นไม้',
            'เก็บขยะชายหาด',
            'อบรมอาชีพ',
            'แจกหน้ากาก',
            'สร้างที่พักผู้โดยสาร',
            'อบรมการแยกขยะ',
            'ทำความสะอาดวัด',
            'จัดนิทรรศการ',
            'เดินรณรงค์ลดขยะ'
        ];

        foreach (range(1, 4) as $catId) {
            foreach (range(1, 10) as $i) {
                $date = Carbon::create(2025, 3, rand(1, 30))->setTime(rand(7, 17), rand(0, 59));
                Activity::create([
                    'act_title' => $titles[array_rand($titles)] . " หมวด " . $catId,
                    'act_description' => 'รายละเอียดของกิจกรรมในหมวดหมู่ ' . $catId,
                    'act_cat_id' => $catId,
                    'act_date' => $date->toDateString(),
                    'status' => $statuses[array_rand($statuses)],
                    'act_submit_by' => rand(1, 10),
                    'act_save_by' => rand(1, 10),
                    'created_at' => $date,
                    'updated_at' => $date->copy()->addMinutes(rand(10, 90)),
                ]);
            }
        }
    }
}