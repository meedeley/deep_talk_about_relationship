<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $cities = [
            [
                "seller_id" => 1,
                "name" => "Blitar"
            ],
            [
                "seller_id" => 2,
                "name" => "Malang"
            ],
            [
                "seller_id" => 3,
                "name" => "Surabaya"
            ],
            [
                "seller_id" => 4,
                "name" => "Magelang"
            ]
        ];

        foreach ($cities as $city) {
            City::query()->create($city);
        }
    }
}
