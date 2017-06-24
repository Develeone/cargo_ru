<?php

namespace App\Http\Controllers;

use App\City;
use App\CityRegion;
use Illuminate\Http\Request;

class GeoController extends Controller
{
    function getRegionsByCountryId ($id) {
        return CityRegion::select("id", "name")
            ->where("country_id", $id)
            ->get();
    }

    function getCitiesByRegionId ($id) {
        return City::select("id", "name")
            ->where("region_id", $id)
            ->get();
    }
}
