<?php

namespace App\Http\Controllers;

use App\Ads;
use Illuminate\Http\Request;

class AdsController extends Controller
{
    static function getBlock($block_id) {
        return json_encode(Ads::select("img_link","redirect_url")
            ->where('block_id', $block_id)
            ->get());
    }
}
