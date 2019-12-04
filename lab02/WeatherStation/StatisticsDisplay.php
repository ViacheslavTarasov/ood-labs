<?php

namespace Lab02\WeatherStation;

use Lab02\Common\DisplayInterface;
use Lab02\Common\InsideStatistics;
use Lab02\Common\ObservableInterface;
use Lab02\Common\ObserverInterface;
use Lab02\Common\PrintHelper;

class StatisticsDisplay implements ObserverInterface, DisplayInterface
{
    private $insideStatistics;
    private $printHelper;

    public function __construct(WeatherData $weatherData, InsideStatistics $insideStatistics)
    {
        $weatherData->registerObserver($this);
        $this->insideStatistics = $insideStatistics;
        $this->printHelper = new PrintHelper();
    }

    public function update(ObservableInterface $observable)
    {
        if ($observable instanceof WeatherData) {
            $this->insideStatistics->addTemperature($observable->getTemperature());
            $this->insideStatistics->addHumidity($observable->getHumidity());
            $this->insideStatistics->addPressure($observable->getPressure());
            $this->display();
        }
    }

    public function display()
    {
        $this->printHelper->printStatistics('temperature', $this->insideStatistics->getTemperatureStatistics());
        $this->printHelper->printStatistics('humidity', $this->insideStatistics->getHumidityStatistics());
        $this->printHelper->printStatistics('pressure', $this->insideStatistics->getPressureStatistics());
        echo PHP_EOL;
    }
}