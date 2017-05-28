<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryWithCities extends Model
{
    protected $fillable = ['category_id'];

    protected $table = "categories_with_cities";
}
