<?php

namespace Database\Seeders;

use App\Models\Flight;
use App\Models\Ticket;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $flights = Flight::all();
        
        $tickets = [
            ['code' => 'AA123'],
            ['code' => 'BB456'],
            ['code' => 'CC789'],
            ['code' => 'DD012'],
            ['code' => 'EE345'],
            ['code' => 'FF678'],
            ['code' => 'GG901'],
            ['code' => 'HH234'],
            ['code' => 'II567'],
            ['code' => 'JJ890'],
        ];

        foreach ($tickets as $ticket) {
            Ticket::query()->create([
                'flight_id' => $flights->random()->id,
                'code' => $ticket['code'],
            ]);
        }
    }
}
