<?php


namespace Lab02\WeatherStation;


class StatisticsDisplay implements Observer, Display
{
    private $temperatureStatistics;
    private $humidityStatistics;
    private $pressureStatistics;

    public function __construct(WeatherData $weatherData)
    {
        $weatherData->registerObserver($this);
        $this->temperatureStatistics = new Statistics();
        $this->humidityStatistics = new Statistics();
        $this->pressureStatistics = new Statistics();
    }

    public function update(Observable $observable)
    {
        if ($observable instanceof WeatherData) {
            $this->temperatureStatistics->add($observable->getTemperature());
            $this->humidityStatistics->add($observable->getHumidity());
            $this->pressureStatistics->add($observable->getPressure());

            $this->display();
        }

    }

    public function display()
    {
        echo "Temperature statistics - " . $this->displayStat($this->temperatureStatistics) . PHP_EOL;
        echo "Humidity statistics - " . $this->displayStat($this->humidityStatistics) . PHP_EOL;
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