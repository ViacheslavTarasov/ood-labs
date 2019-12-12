<?php


namespace Lab02\WeatherStationProEvent;


use Closure;
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
    protected $eventListeners = [];

    public function subscribe(string $event, Closure $eventListener, int $priority = 0)
    {
        $this->validateEventOrException($event);
        if (!isset($this->eventListeners[$event])) {
            $this->eventListeners[$event] = new PriorityStorage();
        }
        $this->eventListeners[$event]->attach($eventListener, $priority);
    }

    public function unsubscribe(string $event, Closure $eventListener)
    {
        $this->validateEventOrException($event);
        if (isset($this->eventListeners[$event])) {
            $this->eventListeners[$event]->detach($eventListener);
        }
    }

    public function removeEventListener(Closure $eventListener)
    {
        foreach ($this->eventListeners as $eventListeners) {
            $eventListeners->detach($eventListener);
        }
    }

    public function notify(string $event)
    {
        if (!isset($this->eventListeners[$event])) {
            return;
        }

        foreach ($this->eventListeners[$event] as $eventListener) {
            $eventListener($this);
        }
    }

    public function setMeasurements(float $temperature, float $humidity, float $pressure, float $windSpeed, float $windDirection)
    {
        if ($this->temperature !== $temperature) {
            $this->temperature = $temperature;
            $this->notify(Events::OUTSIDE_TEMPERATURE);
        }
        if ($this->humidity !== $humidity) {
            $this->humidity = $humidity;
            $this->notify(Events::OUTSIDE_HUMIDITY);
        }
        if ($this->pressure !== $pressure) {
            $this->pressure = $pressure;
            $this->notify(Events::OUTSIDE_PRESSURE);
        }
        if ($this->windSpeed !== $windSpeed) {
            $this->windSpeed = $windSpeed;
            $this->notify(Events::OUTSIDE_WIND_SPEED);
        }
        if ($this->windDirection !== $windDirection) {
            $this->windDirection = $windDirection;
            $this->notify(Events::OUTSIDE_WIND_DIRECTION);
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