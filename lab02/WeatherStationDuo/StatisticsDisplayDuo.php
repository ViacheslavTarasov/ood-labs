<?php


namespace Lab02\WeatherStationDuo;

use Lab02\WeatherStation\Observer;
use Lab02\WeatherStation\WeatherData;
use Lab02\WeatherStation\Statistics;
use Lab02\WeatherStation\Observable;
use Lab02\WeatherStation\Display;

class StatisticsDisplayDuo implements Observer, Display
{
    private $temperatureStatisticsIn;
    private $humidityStatisticsIn;
    private $pressureStatisticsIn;

    private $temperatureStatisticsOut;
    private $humidityStatisticsOut;
    private $pressureStatisticsOut;

    private $weatherDataIn;
    private $weatherDataOut;


    public function __construct(WeatherData $weatherDataIn, WeatherData $weatherDataOut)
    {
        $this->weatherDataIn = $weatherDataIn;
        $this->weatherDataOut = $weatherDataOut;
        $weatherDataIn->registerObserver($this);
        $weatherDataOut->registerObserver($this);

        $this->temperatureStatisticsIn = new Statistics();
        $this->humidityStatisticsIn = new Statistics();
        $this->pressureStatisticsIn = new Statistics();

        $this->temperatureStatisticsOut = new Statistics();
        $this->humidityStatisticsOut = new Statistics();
        $this->pressureStatisticsOut = new Statistics();
    }


    public function update(Observable $observable)
    {
        if ($observable === $this->weatherDataIn) {
            $this->temperatureStatisticsIn->add($observable->getTemperature());
            $this->humidityStatisticsIn->add($observable->getHumidity());
            $this->pressureStatisticsIn->add($observable->getPressure());
        }

        if ($observable === $this->weatherDataOut) {
            $this->temperatureStatisticsOut->add($observable->getTemperature());
            $this->humidityStatisticsOut->add($observable->getHumidity());
            $this->pressureStatisticsOut->add($observable->getPressure());
        }
        $this->display();
    }

    public function display()
    {
        echo "Inside" . PHP_EOL;
        echo "Temperature statistics - " . $this->displayStat($this->temperatureStatisticsIn) . PHP_EOL;
        echo "Humidity statistics - " . $this->displayStat($this->humidityStatisticsIn) . PHP_EOL;
        echo "Pressure statistics - " . $this->displayStat($this->pressureStatisticsIn) . PHP_EOL;
        echo "Outside" . PHP_EOL;
        echo "Temperature statistics - " . $this->displayStat($this->temperatureStatisticsOut) . PHP_EOL;
        echo "Humidity statistics - " . $this->displayStat($this->humidityStatisticsOut) . PHP_EOL;
        echo "Pressure statistics - " . $this->displayStat($this->pressureStatisticsOut) . PHP_EOL;
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