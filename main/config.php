<?php

return [
    'provider' => [
        'AccuWeatherDataProvider' => [
            'apiKey' => '',
            'currentConditionsUrl' => 'http://dataservice.accuweather.com/currentconditions/v1/',
            'citySearchUrl' => 'http://dataservice.accuweather.com/locations/v1/cities/search',
            'iconUrl' => 'https://developer.accuweather.com/sites/default/files/'
        ],
        'OpenWeatherDataProvider' => [
            'apiKey' => '',
            'citySearchUrl' => 'https://api.openweathermap.org/data/2.5/weather',
            'iconUrl' => 'http://openweathermap.org/img/wn/'
        ],
    ]
];
