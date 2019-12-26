<?php

namespace app\model;


use app\resources\Request;
use app\resources\WeatherDataProvider;

class AccuWeatherDataProvider extends WeatherDataProvider
{

    protected function setDbFilename()
    {
        $this->db_filename = 'AW_data.json';
    }

    /**
     * @param $city
     * @return mixed|string
     * @throws \Exception
     */
    protected function getCityId($city)
    {
        $response = Request::fetch(
            'GET',
            $this->config['citySearchUrl'] . "?" . http_build_query([
                'q' => $city,
                'apikey' => $this->config['apiKey'],
                'language' => 'ru',
            ])
        );
        $response = json_decode($response, true);

        if (!isset($response['Code'])) {
            $city = array_shift($response);
            return $city['Key'];
        } else {
            throw new \Exception("{$response['Code']}: {$response['Message']}");
        }
    }

    protected function collectCityData($response) : array
    {
        $response = array_shift($response);
        $data['temp'] = $response['Temperature']['Metric']['Value'];
        $data['description'] = $response['WeatherText'];
        $data['icon'] = $this->config['iconUrl'] .
            str_pad($response['WeatherIcon'],2, '0', STR_PAD_LEFT) .
            '-s.png';
        $data['pressure'] = $response['Pressure']['Metric']['Value'];
        $data['humidity'] = $response['RelativeHumidity'];
        $data['updated_at'] = time();

        return $data;
    }

    protected function getCityDataFromRemote($cityId) : string
    {
        return Request::fetch(
            'GET',
            $this->config['currentConditionsUrl'] . '/' . $cityId . "?" . http_build_query([
                'apikey' => $this->config['apiKey'],
                'language' => 'ru',
                'details' => 'true'
            ])
        );
    }

    protected function checkErrors($response) : array
    {
        if (isset($response['Code'])) {
            return [
                'code' => $response['Code'],
                'message' => $response['Message']
            ];
        } else {
            return [];
        }
    }
}