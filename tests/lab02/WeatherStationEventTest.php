<?php

use Lab02\WeatherStationEvent\Events;
use Lab02\WeatherStationEvent\Observable;
use Lab02\WeatherStationEvent\Observer;
use Lab02\WeatherStationEvent\WeatherData;
use PHPUnit\Framework\TestCase;

class WeatherStationEventTest extends TestCase
{

    public function testPriority()
    {
        $weatherData = new WeatherData();
        $notifiedList = new NotifiedList();
        $list = ['b', 'a', 'c'];
        foreach ($list as $item) {
            $weatherData->subscribeObserver(new SpyDisplay($notifiedList, $item), Events::OUTSIDE_TEMPERATURE);
        }
        $weatherData->setMeasurements(15, 0.65, 750, 20, 270);
        $this->assertTrue($list === $notifiedList->getList());
    }
}

class SpyDisplay implements Observer
{
    private $notifiedList;
    private $name;

    public function __construct(NotifiedList $notifiedList, string $name)
    {
        $this->notifiedList = $notifiedList;
        $this->name = $name;
    }

    public function update(Observable $observable)
    {
        $this->notifiedList->add($this->name);
    }
}

class NotifiedList
{
    private $list;

    public function getList()
    {
        return $this->list;
    }

    public function add($item): void
    {
        $this->list[] = $item;
    }

}
