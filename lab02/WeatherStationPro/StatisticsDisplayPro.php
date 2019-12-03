<?php


namespace Lab02\WeatherStationPro;


use Lab02\WeatherStation\Display;
use Lab02\WeatherStation\Observable;
use Lab02\WeatherStation\Observer;
use Lab02\WeatherStation\Statistics;

class StatisticsDisplayPro implements Observer, Display
{
    private $temperatureStatistics;
    private $humidityStatistics;
    private $pressureStatistics;
    private $windSpeedStatistics;
    private $windDirectionStatistics;

    public function __construct(WeatherDataPro $weatherData)
    {
        $weatherData->registerObserver($this);
        $this->temperatureStatistics = new Statistics();
        $this->humidityStatistics = new Statistics();
        $this->pressureStatistics = new Statistics();
        $this->windSpeedStatistics = new Statistics();
        $this->windDirectionStatistics = new WindDirectionStatistics();
    }

    public function update(Observable $observable)
    {
        if ($observable instanceof WeatherDataPro) {
            $this->temperatureStatistics->add($observable->getTemperature());
            $this->humidityStatistics->add($observable->getHumidity());
            $this->pressureStatistics->add($observable->getPressure());
            $this->windSpeedStatistics->add($observable->getWindSpeed());
            $this->windDirectionStatistics->add($observable->getWindDirection());

            $this->display();
        }

    }

    public function display()
    {
        echo "Temperature statistics - " . $this->displayStat($this->temperatureStatistics) . PHP_EOL;
        echo "Humidity statistics - " . $this->displayStat($this->humidityStatistics) . PHP_EOL;
        echo "Pressure statistics - " . $this->displayStat($this->pressureStatistics) . PHP_EOL;
        echo "Wind speed statistics - " . $this->displayStat($this->windSpeedStatistics) . PHP_EOL;
        echo "Wind direction statistics - Average: " . $this->windDirectionStatistics->getAvg() . PHP_EOL;
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