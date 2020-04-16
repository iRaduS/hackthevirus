<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

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

            $entity->exp += set_exp($distance) * req_time(10, $entity->updated_at, Carbon::now()) * 2; 
            $ban = true;

            if (Carbon::now()->startOfDay()->gt($entity->levelup_at)) {
                $ban = false; // Sa nu poti da de doua ori in aceeasi zi level up
            }
            
            if ($entity->exp > max_exp() * 0.66 && $ban == false) {
                $points = abs($entity->exp - max_exp() * 0.66) * 0.1 + rand(80, 120);
                $user->research_points += $points; // Primeste 10% din punctele ramase (exp) [MAXIM: 1500 (caz ideal)] + ceva intre 80 si 120 ca si Research Points

                $entity->level++;
                $entity->levelup_at = Carbon::now();
                $entity->exp = 0;
            } 

            $user->distance = $distance;
            $user->save();
            $entity->save();

        }

        return response(200);
    }
}
