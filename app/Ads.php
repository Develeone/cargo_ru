<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ads extends Model
{
    protected $fillable = [
        'block_id',
        'advertiser_id',
        'img_link',
        'redirect_url',
        'start_date',
        'finish_date'
    ];

}
