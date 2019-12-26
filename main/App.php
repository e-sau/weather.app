<?php

namespace app\main;

use app\model\Weather;
use app\resources\WeatherDataProvider;

class App
{
    /* @var WeatherDataProvider $dataProvider */
    private $dataProvider;
    /* @var \app\resources\PHPRenderService $renderService */
    private $renderService;

    public function __construct($renderService)
    {
        $this->renderService = $renderService;
    }

    public function setDataProvider(WeatherDataProvider $dataProvider)
    {
        $this->dataProvider = $dataProvider;
    }

    /**
     * @param $city
     * @return Weather
     * @throws \Exception
     */
    protected function getDataForCity($city)
    {
        $data = $this->dataProvider->getDataForCity($city);
        $model = new Weather();
        if ($model->load($data)) {
            return $model;
        } else {
            throw new \Exception('Ошибка загрузки данных');
        }
    }

    /**
     * @param $city
     * @throws \Exception
     */
    public function renderWeatherForCity($city)
    {
        $model = $this->getDataForCity($city);
        $this->render('index', $model);
    }

    public function render($template = 'index', $model = [])
    {
        echo $this->renderService->render($template, $model);
    }
}