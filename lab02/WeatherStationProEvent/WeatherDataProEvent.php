<?php


namespace Lab02\WeatherStationProEvent;

use InvalidArgumentException;
use Lab02\Common\PriorityStorage;

class WeatherDataProEvent implements ObservableEventInterface
{
    private $temperature;
    private $humidity;
    private $pressure;
    private $windSpeed;
    private $windDirection;

    /** @var PriorityStorage[] */
    protected $observers = [];

    public function subscribeObserver(ObserverInterface $observer, string $event, int $priority = 0)
    {
        $this->validateEventOrException($event);
        if (!isset($this->observers[$event])) {
            $this->observers[$event] = new PriorityStorage();
        }
        $this->observers[$event]->attach($observer);
    }


    public function unsubscribeObserver(ObserverInterface $observer, string $event)
    {
        $this->validateEventOrException($event);
        if (isset($this->observers[$event])) {
            $this->observers[$event]->detach($observer);
        }
    }

    public function removeObserver(ObserverInterface $observer)
    {
        foreach ($this->observers as $event => $observers) {
            $observers[$event]->detach($observer);
        }
    }

    public function notifyObservers(string $event)
    {
        if (!isset($this->observers[$event])) {
            return;
        }
        /** @var ObserverInterface $observer */
        foreach ($this->observers[$event] as $observer) {
            $observer->update($this);
        }
    }

    public function setMeasurements(float $temperature, float $humidity, float $pressure, float $windSpeed, float $windDirection)
    {
        if ($this->temperature !== $temperature) {
            $this->temperature = $temperature;
            $this->notifyObservers(Events::OUTSIDE_TEMPERATURE);
        }
        if ($this->humidity !== $humidity) {
            $this->humidity = $humidity;
            $this->notifyObservers(Events::OUTSIDE_HUMIDITY);
        }
        if ($this->pressure !== $pressure) {
            $this->pressure = $pressure;
            $this->notifyObservers(Events::OUTSIDE_PRESSURE);
        }
        if ($this->windSpeed !== $windSpeed) {
            $this->windSpeed = $windSpeed;
            $this->notifyObservers(Events::OUTSIDE_WIND_SPEED);
        }
        if ($this->windDirection !== $windDirection) {
            $this->windDirection = $windDirection;
            $this->notifyObservers(Events::OUTSIDE_WIND_DIRECTION);
        }
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

    private function validateEventOrException($event)
    {
        if (!in_array($event, Events::AVAILABLE_CODES)) {
            throw new InvalidArgumentException('invalid event');
        }
    }
}