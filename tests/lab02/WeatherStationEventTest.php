<?php

use Lab02\WeatherStationProEvent\Events;
use Lab02\WeatherStationProEvent\ObservableEventInterface;
use Lab02\WeatherStationProEvent\ObserverInterface;
use Lab02\WeatherStationProEvent\WeatherDataProEvent;
use PHPUnit\Framework\TestCase;
use Tests\Lab02\NotifiedList;

class WeatherStationEventTest extends TestCase
{

    public function testPriority()
    {
        $weatherData = new WeatherDataProEvent();
        $notifiedList = new NotifiedList();
        $list = ['b', 'a', 'c'];
        foreach ($list as $item) {
            $weatherData->subscribeObserver(new SpyEventDisplay($notifiedList, $item), Events::OUTSIDE_TEMPERATURE);
        }
        $weatherData->setMeasurements(15, 0.65, 750, 20, 270);
        $this->assertTrue($list === $notifiedList->getList());
    }
}

class SpyEventDisplay implements ObserverInterface
{
    private $notifiedList;
    private $name;

    public function __construct(NotifiedList $notifiedList, string $name)
    {
        $this->notifiedList = $notifiedList;
        $this->name = $name;
    }

    public function update(ObservableEventInterface $observable)
    {
        $this->notifiedList->add($this->name);
    }
}
