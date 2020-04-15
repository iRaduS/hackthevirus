<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function location(Request $request) {
        $user =  $request->user();
        $distance = get_distance($user->safe_long, $user->safe_lat, $request->long, $request->lat);
        if ($distance <= env('LOCATION_RADIUS', 50)) {
            $entity = $user->entity;

            // @todo: checks for api

            $entity->exp += set_exp($distance); 
            
            if ($entity->exp > max_exp() * 0.66) {
                $entity->level++;
                $user->research_points += rand(75, 175);
                $entity->exp = 0;
            }
            
            $entity->save();
            $user->save();
        }

        return response(200);
    }
}
