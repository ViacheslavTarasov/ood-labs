<?php


namespace Lab02\WeatherStationPro;

use Lab02\WeatherStation\Observable;
use Lab02\WeatherStation\Observer;
use Lab02\WeatherStation\ObserversStorage;
use Lab02\WeatherStation\WeatherInfo;

class WeatherDataPro implements Observable
{
    private $temperature;
    private $humidity;
    private $pressure;
    private $windSpeed;
    private $windDirection;

    /** @var ObserversStorage */
    protected $observers;

    public function __construct()
    {
        $this->observers = new ObserversStorage();
    }

    public function registerObserver(Observer $observer, int $number = 0)
    {
        $this->observers->attach($observer, $number);
    }

    public function notifyObservers()
    {
        $observers = $this->observers->getArraySortedByPriority();
        /** @var Observer $observer */
        foreach ($observers as $observer) {
            $observer->update($this);
        }
    }

    public function removeObserver(Observer $observer)
    {
        $this->observers->detach($observer);
    }

    public function setMeasurements(float $temperature, float $humidity, float $pressure, float $windSpeed, float $windDirection)
    {
        $this->temperature = $temperature;
        $this->humidity = $humidity;
        $this->pressure = $pressure;
        $this->windSpeed = $windSpeed;
        $this->windDirection = $windDirection;
        $this->measurementsChanged();

    }

    private function measurementsChanged()
    {
        $this->notifyObservers();
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

    public function getWindSpeed()
    {
        return $this->windSpeed;
    }

    public function getWindDirection()
    {
        return $this->windDirection;
    }

    private function getChangedData(): WeatherInfo
    {
        return new WeatherInfo($this->temperature, $this->humidity, $this->pressure);
    }

}