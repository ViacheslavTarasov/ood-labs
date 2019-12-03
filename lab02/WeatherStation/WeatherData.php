<?php


namespace Lab02\WeatherStation;

class WeatherData implements Observable
{
    private $temperature;
    private $humidity;
    private $pressure;

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