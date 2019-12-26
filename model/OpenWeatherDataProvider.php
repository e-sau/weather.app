<?php

namespace app\model;

use app\resources\Request;
use app\resources\WeatherDataProvider;

class OpenWeatherDataProvider extends WeatherDataProvider
{

    protected function setDbFilename()
    {
        $this->db_filename = 'OW_data.json';
    }

    protected function collectCityData($response) : array
    {
        $data['temp'] = round($response['main']['temp'], 1);
        $description = $response['weather'][0]['description'];
        $data['description'] = mb_strtoupper(mb_substr($description, 0, 1)) . mb_substr($description, 1);
        $data['icon'] = $this->config['iconUrl'] . $response['weather'][0]['icon'] . '@2x.png';
        $data['pressure'] = $response['main']['pressure'];
        $data['humidity'] = $response['main']['humidity'];
        $data['updated_at'] = time();

        return $data;
    }

    protected function getCityId($city)
    {
        return $city;
    }

    protected function getCityDataFromRemote($cityId) : string
    {
        return Request::fetch(
            'GET',
            $this->config['citySearchUrl'] . "?" . http_build_query([
                'q' => $cityId,
                'appid' => $this->config['apiKey'],
                'units' => 'metric',
                'lang' => 'ru',
            ]));
    }

    protected function checkErrors($response) : array
    {
        if ($response['cod'] === 200) {
            return [];
        } else {
            return [
                'code' => $response['cod'],
                'message' => $response['message']
            ];
        }
    }
}