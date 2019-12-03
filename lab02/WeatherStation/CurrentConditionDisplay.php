<?php


namespace Lab02\WeatherStation;

class CurrentConditionDisplay implements Observer, Display
{
    private $temperature;
    private $humidity;
    private $pressure;

    public function __construct(WeatherData $weatherData)
    {
        $weatherData->registerObserver($this);
    }

    public function update(Observable $observable)
    {
        if ($observable instanceof WeatherData) {
            $this->temperature = $observable->getTemperature();
            $this->humidity = $observable->getHumidity();
            $this->pressure = $observable->getPressure();

            $this->display();
        }

    }

    public function display()
    {
        echo "Current condition - "
            . " temperature: " . $this->temperature
            . " humidity: " . $this->humidity
            . " pressure: " . $this->pressure . PHP_EOL;
    }


}