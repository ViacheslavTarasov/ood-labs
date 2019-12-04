<?php


namespace Lab02\Common;


class InsideStatistics
{
    private $temperatureStatistics;
    private $humidityStatistics;
    private $pressureStatistics;

    public function __construct()
    {
        $this->temperatureStatistics = new Statistics();
        $this->humidityStatistics = new Statistics();
        $this->pressureStatistics = new Statistics();
    }

    public function addTemperature(float $value)
    {
        $this->temperatureStatistics->add($value);
    }

    public function addHumidity(float $value)
    {
        $this->humidityStatistics->add($value);
    }

    public function addPressure(float $value)
    {
        $this->pressureStatistics->add($value);
    }

    public function getTemperatureStatistics(): Statistics
    {
        return $this->temperatureStatistics;
    }

    public function getHumidityStatistics(): Statistics
    {
        return $this->humidityStatistics;
    }

    public function getPressureStatistics(): Statistics
    {
        return $this->pressureStatistics;
    }


}