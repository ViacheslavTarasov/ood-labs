<?php

namespace Lab02\WeatherStationEvent;


use Lab02\WeatherStation\Display;
use Lab02\WeatherStation\Statistics;

class StatisticsDisplay implements Observer, Display
{
    private $temperatureStatistics;
    private $pressureStatistics;

    public function __construct(WeatherData $weatherData)
    {
        $weatherData->subscribeObserver($this, Events::OUTSIDE_TEMPERATURE);
        $weatherData->subscribeObserver($this, Events::OUTSIDE_PRESSURE);
        $this->temperatureStatistics = new Statistics();
        $this->pressureStatistics = new Statistics();
    }

    public function update(Observable $observable)
    {
        if (!$observable instanceof WeatherData) {
            return;
        }
        if (null !== $observable->getTemperature()) {
            $this->temperatureStatistics->add($observable->getTemperature());
        }
        if (null !== $observable->getPressure()) {
            $this->pressureStatistics->add($observable->getPressure());
        }
        $this->display();


    }

    public function display()
    {
        echo "Temperature statistics - " . $this->displayStat($this->temperatureStatistics) . PHP_EOL;
        echo "Pressure statistics - " . $this->displayStat($this->pressureStatistics) . PHP_EOL;
        echo PHP_EOL;
    }


    private function displayStat(Statistics $statistics)
    {
        $max = $statistics->getMax() ? $statistics->getMax() : 'undefined';
        $min = $statistics->getMin() ? $statistics->getMin() : 'undefined';
        $avg = $statistics->getAvg() ? round($statistics->getAvg(), 2) : 'undefined';
        return "Max: " . $max
            . " Min: " . $min
            . " Average: " . $avg;
    }

}