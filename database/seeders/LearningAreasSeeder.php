<?php

namespace Database\Seeders;

use App\Models\LearningArea;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LearningAreasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = [
            ['name' => 'Mother Tongue', 'code' => 'MT', 'display_order' => 1, 'category' => 'core', 'has_quarterly_grades' => true],
            ['name' => 'Filipino', 'code' => 'FIL', 'display_order' => 2, 'category' => 'core', 'has_quarterly_grades' => true],
            ['name' => 'English', 'code' => 'ENG', 'display_order' => 3, 'category' => 'core', 'has_quarterly_grades' => true],
            ['name' => 'Mathematics', 'code' => 'MATH', 'display_order' => 4, 'category' => 'core', 'has_quarterly_grades' => true],
            ['name' => 'Science', 'code' => 'SCI', 'display_order' => 5, 'category' => 'core', 'has_quarterly_grades' => true],
            ['name' => 'Araling Panlipunan', 'code' => 'AP', 'display_order' => 6, 'category' => 'core', 'has_quarterly_grades' => true],
            ['name' => 'EPP / TLE', 'code' => 'EPP', 'display_order' => 7, 'category' => 'applied', 'has_quarterly_grades' => true],
            ['name' => 'MAPEH', 'code' => 'MAPEH', 'display_order' => 8, 'category' => 'core', 'has_quarterly_grades' => false],
            ['name' => 'Music', 'code' => 'MUSIC', 'display_order' => 9, 'category' => 'enhancement', 'has_quarterly_grades' => true],
            ['name' => 'Arts', 'code' => 'ARTS', 'display_order' => 10, 'category' => 'enhancement', 'has_quarterly_grades' => true],
            ['name' => 'Physical Education', 'code' => 'PE', 'display_order' => 11, 'category' => 'core', 'has_quarterly_grades' => true],
            ['name' => 'Health', 'code' => 'HEALTH', 'display_order' => 12, 'category' => 'core', 'has_quarterly_grades' => true],
            ['name' => 'Edukasyon sa Pagpapakatao', 'code' => 'ESP', 'display_order' => 13, 'category' => 'core', 'has_quarterly_grades' => true],
            ['name' => 'Arabic Language', 'code' => 'ARABIC', 'display_order' => 14, 'category' => 'specialized', 'has_quarterly_grades' => true],
            ['name' => 'Islamic Values Education', 'code' => 'IVE', 'display_order' => 15, 'category' => 'specialized', 'has_quarterly_grades' => true]
        ];

        foreach ($subjects as $subject) {
            LearningArea::create([
                'name' => $subject['name'],
                'code' => $subject['code'],
                'category' => $subject['category'],
                'display_order' => $subject['display_order'],
                'has_quarterly_grades' => $subject['has_quarterly_grades']
            ]);
        }

    }
}
