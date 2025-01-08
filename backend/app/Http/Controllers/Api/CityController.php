<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\CityResource;
use App\Models\City;

class CityController extends Controller
{
     // Mengembalikan daftar semua kota beserta jumlah officeSpaces
    public function index()
    {
        // Menggunakan eager loading untuk mendapatkan jumlah officeSpaces
        $cities = City::withCount('officeSpaces')->with(['officeSpaces.photos', 'officeSpaces.benefits']) ->get();

        // Mengembalikan koleksi CityResource
        return CityResource::collection($cities);
    }

    // Mengembalikan detail kota dengan officeSpaces terkait
    public function show(City $city)
    {

        // Eager loading pada relasi terkait
        $city->load([
            'officeSpaces.city', // Relasi ke model City dalam officeSpaces
            'officeSpaces.photos' // Relasi photos di dalam officeSpaces
        ]);

        // Menambahkan jumlah officeSpaces
        $city->loadCount('officeSpaces');

        // Mengembalikan CityResource
        return new CityResource($city);
    }
}
