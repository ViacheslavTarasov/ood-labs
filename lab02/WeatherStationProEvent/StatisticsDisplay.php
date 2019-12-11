<?php

namespace Lab02\WeatherStationProEvent;


use Lab02\Common\OutsideStatistics;
use Lab02\Common\PrintHelper;

class StatisticsDisplay implements ObserverInterface
{
    private $outsideStatistics;
    private $printHelper;

    public function __construct(
        WeatherDataProEvent $weatherData,
        OutsideStatistics $outsideStatistics
    )
    {
        $weatherData->subscribeObserver($this, Events::OUTSIDE_TEMPERATURE);
        $weatherData->subscribeObserver($this, Events::OUTSIDE_PRESSURE);
        $this->outsideStatistics = $outsideStatistics;
        $this->printHelper = new PrintHelper();
    }

    public function update(ObservableEventInterface $observable)
    {
        if (!$observable instanceof WeatherDataProEvent) {
            return;
        }
        if (null !== $observable->getTemperature()) {
            $this->outsideStatistics->addTemperature($observable->getTemperature());
        }
        if (null !== $observable->getPressure()) {
            $this->outsideStatistics->addPressure($observable->getPressure());
        }
        $this->display();
    }

    public function display()
    {
        $this->printHelper->printStatistics('temperature', $this->outsideStatistics->getTemperatureStatistics());
        $this->printHelper->printStatistics('pressure', $this->outsideStatistics->getPressureStatistics());
        echo PHP_EOL;
    }
}