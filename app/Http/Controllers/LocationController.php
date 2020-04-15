<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function location(Request $request) {
        $distance = get_distance($request->user()->safe_long, $request->user()->safe_lat, $request->long, $request->lat);
        if ($distance <= env('LOCATION_RADIUS', 50)) {
            $entity = $request->user()->entity;

            // @todo: checks for api
            $entity->exp += set_exp($distance); 
            $entity->save();
        }

        return response(200);
    }
}
