<?php


namespace Lab02\WeatherStationProDuo;


use Lab02\WeatherStation\Display;
use Lab02\WeatherStation\Observable;
use Lab02\WeatherStation\Observer;
use Lab02\WeatherStation\Statistics;
use Lab02\WeatherStation\WeatherData;
use Lab02\WeatherStationPro\WeatherDataPro;
use Lab02\WeatherStationPro\WindDirectionStatistics;

class StatisticsDisplayProDuo implements Observer, Display
{

    private $weatherDataIn;
    private $weatherDataOut;

    private $temperatureStatistics;
    private $humidityStatistics;
    private $pressureStatistics;
    private $windSpeedStatistics;
    private $windDirectionStatistics;

    private $temperatureStatisticsIn;
    private $humidityStatisticsIn;
    private $pressureStatisticsIn;


    public function __construct(WeatherData $weatherDataIn, WeatherDataPro $weatherDataOut)
    {

        $this->weatherDataIn = $weatherDataIn;
        $this->weatherDataOut = $weatherDataOut;
        $weatherDataIn->registerObserver($this);
        $weatherDataOut->registerObserver($this);

        $this->temperatureStatisticsIn = new Statistics();
        $this->humidityStatisticsIn = new Statistics();
        $this->pressureStatisticsIn = new Statistics();

        $this->temperatureStatistics = new Statistics();
        $this->humidityStatistics = new Statistics();
        $this->pressureStatistics = new Statistics();
        $this->windSpeedStatistics = new Statistics();
        $this->windDirectionStatistics = new WindDirectionStatistics();
    }

    public function update(Observable $observable)
    {
        if ($observable === $this->weatherDataIn) {
            $this->temperatureStatisticsIn->add($observable->getTemperature());
            $this->humidityStatisticsIn->add($observable->getHumidity());
            $this->pressureStatisticsIn->add($observable->getPressure());
        }

        if ($observable === $this->weatherDataOut) {
            $this->temperatureStatistics->add($observable->getTemperature());
            $this->humidityStatistics->add($observable->getHumidity());
            $this->pressureStatistics->add($observable->getPressure());
            $this->windSpeedStatistics->add($observable->getWindSpeed());
            $this->windDirectionStatistics->add($observable->getWindDirection());
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