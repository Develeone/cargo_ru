<?php

namespace App\Http\Controllers;

use App\Category;
use App\Question;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    function getContent ($category_id, Request $request) {
        $category = Category::where("id", $category_id)
            ->with('needCities')
            ->first();

        $questions = null;

        $geoSelector = "";
        $geoValue = "";
        if ($request->has("city")) {
            $geoSelector = "city_id";
            $geoValue = $request->get("city");
        }
        elseif ($request->has("region")) {
            $geoSelector = "region_id";
            $geoValue = $request->get("region");
        }
        elseif ($request->has("country")) {
            $geoSelector = "country_id";
            $geoValue = $request->get("country");
        }

        $questions = Question::where("category_id", $category_id);

        if ($geoValue != "")
                $questions = $questions->where($geoSelector, $geoValue);

        $questions = $questions->orderBy("id", "desc")->simplePaginate(15);

        $questions->map(function ($question) {
            $date = date_format($question->created_at, 'd.m.Y');
            $question->date = $date;
        });

        $sortedQuestions = [];
        foreach($questions as $question)
        {
            $date = $question->date;

            if (!isset($sortedQuestions[$date]))
                $sortedQuestions[$date] = collect();

            $sortedQuestions[$date]->push($question);
        }

        $category->groupedQuestions = collect($sortedQuestions);

        $category->geoParams = $this->geoParams($category_id);

        return json_encode($category);
    }

    function getGeoParams($category_id) {
        return json_encode($this->geoParams($category_id));
    }

    function geoParams($category_id){
        $response = new \stdClass();

        $category = Category::where("id", $category_id)
            ->with("needCities")
            ->first();

        if ($category->needCities) {
            $response->cities = $category->needCities->cities;
            $response->regions = $category->needCities->regions;
            $response->countries = $category->needCities->countries;
        } else {
            $response->cities = false;
            $response->regions = false;
            $response->countries = false;
        }

        return $response;
    }
}
