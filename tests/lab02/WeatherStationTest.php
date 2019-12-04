<?php

use Lab02\Common\InsideStatistics;
use Lab02\Common\ObservableInterface;
use Lab02\Common\ObserverInterface;
use Lab02\WeatherStation\StatisticsDisplay;
use Lab02\WeatherStation\WeatherData;
use PHPUnit\Framework\TestCase;
use Tests\Lab02\NotifiedList;
use Tests\Lab02\SpyDisplay;

class WeatherStationTest extends TestCase
{
    public function test()
    {
        $weatherData = new WeatherData();
        $insideStatistics = new InsideStatistics();
        $display = new StatisticsDisplay($weatherData, $insideStatistics);
        $weatherData->setMeasurements(15, 0.65, 750);
        $this->assertEquals($insideStatistics->getTemperatureStatistics()->getMin(), 15);
        $this->assertEquals($insideStatistics->getHumidityStatistics()->getMin(), 0.65);
        $this->assertEquals($insideStatistics->getPressureStatistics()->getMin(), 750);
    }

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


class selfDeleteDisplay implements ObserverInterface
{
    private $weatherData;

    public function __construct(ObservableInterface $weatherData)
    {
        $weatherData->registerObserver($this);
        $this->weatherData = $weatherData;
    }

    public function update(ObservableInterface $observable)
    {
        $observable->removeObserver($this);
    }

}