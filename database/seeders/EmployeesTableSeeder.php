<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('employees')->truncate();
        DB::table('employees')->insert([
            [
                'name' => 'AAA',
                'department' => '技術部',
                'position' => '新人',
                'email' => 'aaa@example.com',
                'job_status' => '勤務中',
            ],
            [
                'name' => 'BBB',
                'department' => '人事部',
                'position' => '新人',
                'email' => 'bbb@example.com',
                'job_status' => '勤務中',
            ],
            [
                'name' => 'CCC',
                'department' => '営業部',
                'position' => 'シニア営業担当',
                'email' => 'ccc@example.com',
                'job_status' => '勤務中',
            ],
            [
                'name' => 'DDD',
                'department' => '経理部',
                'position' => 'シニア',
                'email' => 'ddd@example.com',
                'job_status' => '勤務中',
            ],
            [
                'name' => 'EEE',
                'department' => 'デザインチーム',
                'position' => 'UIデザイナー',
                'email' => 'eee@example.com',
                'job_status' => '休職中',
            ],
        ]);
    }
}
