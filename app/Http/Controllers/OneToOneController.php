<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Seller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class OneToOneController extends Controller
{

    /*
    -- Mempelajari Collection Di Relasi One To One
    1. With - Digunakan untuk eager loading relasi sebelum query dijalankan, cocok jika relasi sudah pasti diperlukan sejak awal untuk mencegah N+1 query dan meningkatkan efisiensi.
    2. Load - Digunakan untuk eager loading relasi setelah query dijalankan, berguna jika kebutuhan meload relasi baru diputuskan setelah data utama diambil.
    3. Pluck - Mengambil semua nilai dari satu kolom dalam tabel.
    4. Find - Mencari Id Table
    5. Cookie - Data Simpan Disisi Client
    6. Session - Data Disimpan Disisi Server
    7. toJson - Mengubah data menjadi format JSON string.
    8. toArray - Mengubah data menjadi format array PHP.
    9. json_encode - Mengubah data PHP (array atau objek) menjadi string JSON.
    10. json_decode -  Mengubah string JSON menjadi data PHP (array atau objek).
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

    public function saveCityToSession() {
        $city = City::query()->get();

        Session::put('city', $city);

        $getSession = Session::get('city');

        return $this->responseServer(200, [
            "statusCode" => 200,
            "data" => $getSession
        ]);

    }
}
