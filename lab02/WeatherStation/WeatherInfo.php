<?php


namespace Lab02\WeatherStation;


class WeatherInfo
{
    private $temperature;
    private $humidity;
    private $pressure;

    public function __construct(float $temperature, float $humidity, float $pressure)
    {
        $this->temperature = $temperature;
        $this->humidity = $humidity;
        $this->pressure = $pressure;
    }

    public function getTemperature()
    {
        return $this->temperature;
    }

    public function getHumidity()
    {
        return $this->humidity;
    }

    public function getPressure()
    {
        return $this->pressure;
    }

}