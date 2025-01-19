<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Seller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class OneToOneController extends Controller
{

    /*
    -- Mempelajari Collection Di Relasi One To One
    1. With
    2. Load
    3. Pluck
    4. Find
    5. 

    */

    public function getSellers()
    {
        $seller = Seller::query()->with('city')->get();

        return $this->responseServer(200, [
            "statusCode" => 200,
            "data" => $seller
        ]);
    }

    public function getCities()
    {
        $cities = City::query()->get();

        return $this->responseServer(200, [
            "statusCode" => 200,
            "data" => $cities->load('seller')
        ]);
    }

    public function getNameCity(): JsonResponse
    {
        $city = City::query()->select('name')->with('seller')->get()->pluck('name');

        $result = collect(value: $city)->map(function ($name) {
            return [
                "name" => $name
            ];
        });
        return $this->responseServer(200, [
            "statusCode" => 200,
            "data" => $result
        ]);
    }

    public function getCityById(string $id): JsonResponse
    {
        $city = City::query()->find($id);

        return $this->responseServer(200, [
            "statusCode" => 200,
            "data" => $city
        ]);
    }

    public function sellerJsonToCollect()
    {
        $sellers = Seller::query()->with('city')->limit(1)->get();

        $toJsonSeller = $sellers->toJson();

        $toDecodeJson = json_decode($toJsonSeller, true);

        $toCollectSeller = collect($sellers);

        $toJsonEncode = json_encode($toCollectSeller);

        return $this->responseServer(200, [
            "statusCode" => 200,
            "json" => $toJsonSeller,
            "json_decode" => $toDecodeJson,
            "json_encode" => $toJsonEncode,
            "collect" => $toCollectSeller
        ]);
    }

    public function saveSellerToCookie()
    {
        $seller = Seller::query()->get();

        // => Cookie Itu Hanya Bisa Menyimpan String
        $createCookie = Cookie::make('seller', $seller->toJson());

        return $this->responseServer(200, [
            "statusCode" => 200,
        ])->withCookie($createCookie);
    } // Method GET

    public function getCookie()
    {
        $cookie = Cookie::get('seller');

        $toArray = json_decode($cookie);

        return $this->responseServer(200, [
            "statusCode" => 200,
            "cookie" => $toArray
        ])->withCookie($cookie);
    }

    public function saveSellerToSession() {}
}
