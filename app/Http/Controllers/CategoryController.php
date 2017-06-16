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

        if ($request->has("city")) {
            $questions = Question::where("category_id", $category_id)
                ->where("city_id", $request->get("city"))
                ->orderBy("id", "desc")
                ->simplePaginate(5);

            $category->city = $request->get("city");
        }
        else
            $questions = Question::where("category_id", $category_id)
                ->orderBy("id", "desc")
                ->simplePaginate(5);

        //$category->links = dd($questions->links());

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


        return json_encode($category);
    }
}
