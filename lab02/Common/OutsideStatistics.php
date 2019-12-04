<?php


namespace Lab02\Common;


class OutsideStatistics
{
    private $temperatureStatistics;
    private $humidityStatistics;
    private $pressureStatistics;
    private $windSpeedStatistics;
    private $windDirectionStatistics;

    public function __construct()
    {
        $this->temperatureStatistics = new Statistics();
        $this->humidityStatistics = new Statistics();
        $this->pressureStatistics = new Statistics();
        $this->windSpeedStatistics = new Statistics();
        $this->windDirectionStatistics = new WindDirectionStatistics();
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

    public function addWindSpeed(float $value)
    {
        $this->windSpeedStatistics->add($value);
    }

    public function addWindDirection(float $value)
    {
        $this->windDirectionStatistics->add($value);
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

    public function getWindSpeedStatistics(): Statistics
    {
        return $this->windSpeedStatistics;
    }

    public function getWindDirectionStatistics(): WindDirectionStatistics
    {
        return $this->windDirectionStatistics;
    }


}