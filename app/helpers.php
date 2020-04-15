<?php

if (!function_exists('get_distance')) {
    function get_distance($longitude, $latitude, $longitudeActual, $latitudeActual) {
        if (is_null($longitude) || is_null($latitude) || is_null($longitudeActual) || $is_null($latitudeActual)) return 100; //div by zero is not an option. say no to it!
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
    function set_exp($distance, $xp = 1.5) {
        $value = 0;
        if ($distance < env('LOCATION_RADIUS', 50) && $distance >= 0) {
            $value = (env('LOCATION_RADIUS', 50) - $distance) * $xp;
        }
   
        return $value;
    }
}