<?php

use Lab02\WeatherStation\Observable;
use Lab02\WeatherStation\Observer;
use Lab02\WeatherStation\WeatherData;
use PHPUnit\Framework\TestCase;

class WeatherStationTest extends TestCase
{
    public function testNotifyWhenObserverRemoveSelf()
    {
        $weatherData = new WeatherData();
        $display = new selfDeleteDisplay($weatherData);
        $weatherData->setMeasurements(15, 0.65, 750);
        $this->assertTrue(true);
    }

    public function testPriority()
    {
        $weatherData = new WeatherData();
        $notifiedList = new NotifiedList();
        $list = ['b', 'a', 'c'];
        foreach ($list as $item) {
            $weatherData->registerObserver(new SpyDisplay($notifiedList, $item));
        }
        $weatherData->setMeasurements(15, 0.65, 750);
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

class selfDeleteDisplay implements Observer
{
    private $weatherData;

    public function __construct(Observable $weatherData)
    {
        $weatherData->removeObserver($this);
        $this->weatherData = $weatherData;
    }

    public function update(Observable $observable)
    {
        var_dump('sdsgd');
        $observable->removeObserver($this);
    }

}