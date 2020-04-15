<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entity;

class LocationController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function location(Request $request) {
        $distance = get_distance($request->user()->safe_long, $request->user()->safe_lat, $request->long, $request->lat);
        if ($distance <= env('LOCATION_RADIUS', 50)) {
            $entity = Entity::where('user_id', $request->user()->id)->first();

            // @todo: checks for api
            $entity->exp += set_exp($distance); 
            $entity->save();
        }

        return response(200);
    }
}
