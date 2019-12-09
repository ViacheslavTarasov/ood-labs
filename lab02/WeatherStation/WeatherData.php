<?php


namespace Lab02\WeatherStation;

use Lab02\Common\ObservableInterface;
use Lab02\Common\ObserverInterface;
use Lab02\Common\PriorityStorage;
use Lab02\Common\WeatherInfo;

class WeatherData implements ObservableInterface
{
    private $temperature;
    private $humidity;
    private $pressure;

    /** @var PriorityStorage */
    protected $observers;

    public function __construct()
    {
        $this->observers = new PriorityStorage();
    }

    public function registerObserver(ObserverInterface $observer, int $priority = 0)
    {
        $this->observers->attach($observer, $priority);
    }

    public function notifyObservers()
    {
        /** @var ObserverInterface $observer */
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }

    public function removeObserver(ObserverInterface $observer)
    {
        $this->observers->detach($observer);
    }

    public function setMeasurements(float $temperature, float $humidity, float $pressure)
    {
        $this->temperature = $temperature;
        $this->humidity = $humidity;
        $this->pressure = $pressure;
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

    private function getChangedData(): WeatherInfo
    {
        return new WeatherInfo($this->temperature, $this->humidity, $this->pressure);
    }

}