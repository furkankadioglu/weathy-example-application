<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\ApiController;
use App\Http\Resources\CityResource;
use App\Models\City;

class CityController extends ApiController
{
    public function index()
    {
        $cities = City::get();

        return $this->respondWithData(CityResource::collection($cities));
    }
}
