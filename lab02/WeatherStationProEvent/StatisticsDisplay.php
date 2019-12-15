<?php


namespace Lab02\WeatherStationProEvent;


use Lab02\Common\OutsideStatistics;
use Lab02\Common\PrintHelper;

class StatisticsDisplay
{
    private $outsideStatistics;
    private $printHelper;
    private $onTemperatureChangeCallback;
    private $onPressureChangeCallback;

    public function __construct(
        OutsideStatistics $outsideStatistics,
        WeatherDataProEvent $weatherData
    )
    {
        $this->outsideStatistics = $outsideStatistics;
        $this->printHelper = new PrintHelper();
        $weatherData->subscribe(Events::OUTSIDE_TEMPERATURE, $this->initOnTemperatureChangeCallback());
        $weatherData->subscribe(Events::OUTSIDE_PRESSURE, $this->initOnPressureChangeCallback());
    }

    private function initOnTemperatureChangeCallback()
    {
        if (!isset($this->onTemperatureChangeCallback)) {
            $self = $this;
            $this->onTemperatureChangeCallback = function (WeatherDataProEvent $weatherData) use ($self) {
                $self->outsideStatistics->addTemperature($weatherData->getTemperature());
                $self->display();
            };
        }
        return $this->onTemperatureChangeCallback;
    }

    private function initOnPressureChangeCallback()
    {
        if (!isset($this->onPressureChangeCallback)) {
            $self = $this;
            $this->onPressureChangeCallback = function (WeatherDataProEvent $weatherData) use ($self) {
                $self->outsideStatistics->addPressure($weatherData->getPressure());
                $self->display();
            };
        }
        return $this->onPressureChangeCallback;
    }

    public function getOnTemperatureChangeCallback()
    {
        return $this->onTemperatureChangeCallback;
    }
    public function getOnPressureChangeCallback()
    {
        return $this->onPressureChangeCallback;
    }

    public function display()
    {
        $this->printHelper->printStatistics('temperature', $this->outsideStatistics->getTemperatureStatistics());
        $this->printHelper->printStatistics('pressure', $this->outsideStatistics->getPressureStatistics());
        echo PHP_EOL;
    }
}