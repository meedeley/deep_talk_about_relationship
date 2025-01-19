<?php

namespace Database\Seeders;

use App\Models\Seller;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SellerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sellers = [
            [
                "name" => "Sudjatmoko"
            ],
            [
                "name" => "Sukarni"
            ],
            [
                "name" => "Sukamto"
            ],
            [
                "name" => "Kaseman"
            ]
            ];

            foreach($sellers as $seller) {
                Seller::query()->create($seller);
            }
    }
}
