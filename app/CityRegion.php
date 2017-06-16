<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CityRegion extends Model
{
    protected $fillable = ['name'];

    function cities()
    {
        return $this->hasMany('App\City', "region_id", "id");
    }
}
