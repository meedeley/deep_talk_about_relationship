<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class OneToManyController extends Controller
{

    public function getTickets(Request $request)
    {
        $params = $request->query('search');

        $ticket = Ticket::query()->withExists('flight')->when($params, function (Builder $query) use ($params) {
            $query->where('code', 'LIKE', "%" . $params . "%");
        })->get();
        return $this->responseServer(200, [
            "statusCode" => 200,
            "data" => $ticket
        ]);
    }

    public function getFlights(Request $request)
    {
        $searchTicket = $request->query('ticket');

        $flight = Flight::query()->with(['tickets' => function ($query) use ($searchTicket) {
            $query->when($searchTicket, function ($query) use ($searchTicket) {
                $query->where('code', "LIKE", '%' . $searchTicket . '%');
            });
        }])->get();

        return $this->responseServer(200, [
            "statusCode" => 200,
            "data" => $flight
        ]);
    }

    public function countTicket()
    {
        $flights = Flight::withCount('tickets')->get();

        return $this->responseServer(200, [
            "statusCode" => 200,
            "data" => $flights
        ]);
    }

    public function getTicketRelationship()
    {
        $ticket = Ticket::query()->find(1);

        $result = $ticket->flight()->first();

        return $this->responseServer(200, [
            "statusCode" => 200,
            "data" => $result
        ]);
    }

    public function setFlightRelationship(Request $request)
    {
        $flight = Flight::query()->find(1);

        $result = $flight->tickets()->create([
            "code" => $request->code
        ]);

        return $this->responseServer(200, [
            "statusCode" => 200,
            "data" => $result
        ]);
    }

    public function getFlightRelationship(Request $request)
    {
        $flight = Flight::query()->find(1);

        $result = $flight->tickets()->create([
            "code" => $request->code
        ]);

        return $this->responseServer(200, [
            "statusCode" => 200,
            "data" => $result
        ]);
    }
}
