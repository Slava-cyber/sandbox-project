<?php

namespace App\System;

class TimeZone
{
    private $timezone;

    public function __construct($city)
    {
        $api_key = 'a160c18ee4ada4b40d900466c832d026';
        $city_info =
            file_get_contents('http://api.openweathermap.org/geo/1.0/direct?q=' . $city . '&limit=1&appid=' . $api_key);
        $city_info = json_decode($city_info, true);
        $lat = $city_info[0]['lat'];
        $lon = $city_info[0]['lon'];
        $weather =
            file_get_contents('https://api.openweathermap.org/data/2.5/weather?lat=' . $lat .
                '&lon=' . $lon . '&appid=' . $api_key . '&units=metric&lang=ru');
        $weather = json_decode($weather);
        $this->timezone = $weather->timezone;
    }

    public function timezone()
    {
        return $this->timezone;
    }
}
