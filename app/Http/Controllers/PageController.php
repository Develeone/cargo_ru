<?php

namespace App\Http\Controllers;

use App\Category;
use App\CityRegion;

class PageController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $regions = CityRegion::select()
            ->with('cities')
            ->get();

        return view('index', [
            "categories" => $categories,
            "regions" => $regions
        ]);
    }

    public function adsPage() {
        return view('ads');
    }
}
