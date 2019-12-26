<?php


namespace app\model;


class Weather
{
    public $city;
    public $description;
    public $temp;
    public $pressure;
    public $humidity;
    public $icon;
    public $updated_at;

    public function load($data)
    {
        if (empty($data)) return false;

        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
        return true;
    }
}