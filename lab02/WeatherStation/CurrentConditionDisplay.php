<?php


namespace Lab02\WeatherStation;

use Lab02\Common\DisplayInterface;
use Lab02\Common\ObservableInterface;
use Lab02\Common\ObserverInterface;

class CurrentConditionDisplay implements ObserverInterface, DisplayInterface
{
    private $temperature;
    private $humidity;
    private $pressure;

    public function __construct(WeatherData $weatherData)
    {
        $weatherData->registerObserver($this);
    }

    public function update(ObservableInterface $observable)
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
        echo "current condition (temperature, humidity, pressure): {$this->temperature} {$this->humidity} {$this->pressure}" . PHP_EOL;
    }
}