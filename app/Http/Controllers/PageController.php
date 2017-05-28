<?php

namespace App\Http\Controllers;

use App\Category;
use App\City;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    public function index()
    {
        $categories = Category::select()
            ->with('questions', 'needCities')
            ->get();

        $cities = City::all();

        $categories->map(function ($category) use ($cities) {
            if ($category->needCities)
                $category->cities = $cities;

            $category->questions->map(function ($question) {
                $date = date_format($question->created_at, 'Y-m-d');
                $question->date = $date;
            });

            $sortedQuestions = [];
            foreach($category->questions as $question)
            {
                $date = $question->date;
                $id = $question->id;

                if (!isset($sortedQuestions[$date]))
                    $sortedQuestions[$date] = collect();

                $sortedQuestions[$date]->push($question);
            }

            $category->groupedQuestions = collect($sortedQuestions);
        });

        return view('index', [
            "categories" => $categories
        ]);
    }
}
