<?php

namespace Database\Seeders;

use App\Models\Flight;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FlightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $flights = [
            ['name' => 'Air Asia'],
            ['name' => 'Garuda Indonesia'],
            ['name' => 'Lion Air'],
            ['name' => 'Batik Air'],
            ['name' => 'Citilink'],
        ];

        foreach ($flights as $flight) {
            Flight::query()->create($flight);
        }
    }
}
