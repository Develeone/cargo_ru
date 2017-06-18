<?php

namespace App\Http\Controllers;

use App\Category;
use App\CityRegion;
use Illuminate\Support\Facades\Auth;

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

    public function adminPage() {
        if (!Auth::user()->is_admin)
            return response("You have not permission to view this page", 403);

        return view('admin');
    }
}
