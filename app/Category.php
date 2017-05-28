<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name'];

    protected $rules = [
        'name' => 'required|min:3|max:25',
    ];

    public $timestamps = false;

    function questions()
    {
        $now = Carbon::now();

        return $this->hasMany('App\Question')
            ->where('created_at', '>', $now->addDay(-10))
            ->orderBy('created_at', "DESC");
    }

    function needCities()
    {
        return $this->hasOne('App\CategoryWithCities');
    }

}
