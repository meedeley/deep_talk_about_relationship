<?php

namespace Database\Seeders;

use App\Models\Hobby;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HobbySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hobbies = [
            'Football',
            'Basketball',
            'Swimming',
            'Cycling',
            'Reading',
            'Gaming',
            'Cooking',
            'Photography',
            'Traveling',
            'Painting'
        ];
    
        foreach ($hobbies as $hobbyName) {
            Hobby::query()->create([
                'name' => $hobbyName,
            ]);
        }
    }
}
