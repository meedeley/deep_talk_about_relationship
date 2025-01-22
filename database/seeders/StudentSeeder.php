<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = [
            ['name' => 'John Doe', 'exp' => 1],
            ['name' => 'Jane Smith', 'exp' => 2],
            ['name' => 'Michael Johnson', 'exp' => 3],
            ['name' => 'Emily Davis', 'exp' => 4],
            ['name' => 'David Brown', 'exp' => 5],
        ];

        foreach ($students as $student) {
            Student::query()->create($student);
        }
    }
}
