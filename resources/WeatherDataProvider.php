<?php

namespace app\resources;

abstract class WeatherDataProvider
{
    protected $config;
    protected $db_filename;

    abstract protected function setDbFilename();

    abstract protected function getCityId($city);

    abstract protected function getCityDataFromRemote($cityId) : string;

    /**
     * @param $response
     * @return array If errors exists set 'code' and 'message' values else return empty array.
     */
    abstract protected function checkErrors($response) : array;

    abstract protected function collectCityData($response) : array;

    /**
     * WeatherDataProvider constructor.
     * @param $config
     * @throws \ReflectionException
     */
    public function __construct($config)
    {
        $className = (new \ReflectionClass($this))->getShortName();
        $this->config = $config['provider'][$className];
        $this->setDbFilename();
    }

    /**
     * Template method
     * @param string $city
     * @return bool|mixed
     * @throws \Exception
     */
    public function getDataForCity(string $city) {

        if ($data = $this->getCityDataFromCache($city)) {
            return $data;
        }

        $cityId   = $this->getCityId($city);
        $response = $this->getCityDataFromRemote($cityId);
        $response = json_decode($response, true);
        $error    = $this->checkErrors($response);

        if (empty($error)) {
            $data = $this->collectCityData($response);
            $data['city'] = preg_replace('#^[^A-zА-ЯЁе]$#ui', '', $city);
            $this->writeCityDataIntoCache($data);
            return $data;
        } else {
            $msg = isset($error['code'], $error['message']) ?
                "{$error['code']}: {$error['message']}" : "Undefined error";
            throw new \Exception($msg);
        }
    }

    protected function writeCityDataIntoCache($data)
    {
        file_put_contents($this->db_filename, json_encode($data));
    }

    protected function getCityDataFromCache($city) : array
    {
        $data = json_decode(@file_get_contents($this->db_filename), true);
        if (isset($data['city'], $data['updated_at']) &&
            $data['city'] === $city &&
            $data['updated_at'] > time() - 30) {
            return $data;
        }
        return [];
    }
}