<?php

if (!function_exists('get_distance')) {
    function get_distance($longitude, $latitude, $longitudeActual, $latitudeActual) {
        if (is_null($longitude) || is_null($latitude) || is_null($longitudeActual) || is_null($latitudeActual)) return -1; //div by zero is not an option. say no to it!
        $earthRadius = env('EARTH_RADIUS', 6371);
      
        $lat = deg2rad($latitudeActual - $latitude);  
        $long = deg2rad($longitudeActual - $longitude);  
        
        $value = sin($lat/2) * sin($lat/2) + cos(deg2rad($latitude)) * cos(deg2rad($latitudeActual)) * sin($long/2) * sin($long/2);  
        $temp = 2 * asin(sqrt($value));  
        $distance = $earthRadius * $temp * 1000; // meters
        
        return $distance;
    }
}

if (!function_exists('set_exp')) {
    function set_exp($distance, $ratio = 0.05) {
        $value = 0;
        if ($distance < env('LOCATION_RADIUS', 50)) {
            if ($distance < 15)
                $value = (env('LOCATION_RADIUS', 50)) * $ratio;
            else 
                $value = (env('LOCATION_RADIUS', 50) - $distance) * $ratio;
        }
   
        return $value;
    }
}

if (!function_exists('max_exp')) {
    function max_exp($ratio = 0.05) {
        $api_calls = 60*60*24 / 5; // how many times set_exp is called per day
        return $api_calls * env('LOCATION_RADIUS', 50) * $ratio;
    }
}

if (!function_exists('req_time')) {
    function  req_time($cooldown = 10, $start, $end){
        if ($end->diffInSeconds($start) >= $cooldown) {
            return 1;
        } else if ($end->diffInSeconds($start) > 0) {
            return ($end->diffInSeconds($start)) / 10;
        } else return 0;
    }
}