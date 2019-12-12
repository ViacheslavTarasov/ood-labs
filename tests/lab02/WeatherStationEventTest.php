<?php

use Lab02\Common\OutsideStatistics;
use Lab02\WeatherStationProEvent\Events;
use Lab02\WeatherStationProEvent\StatisticsDisplay;
use Lab02\WeatherStationProEvent\WeatherDataProEvent;
use PHPUnit\Framework\TestCase;
use Tests\Lab02\NotifiedList;

class WeatherStationEventTest extends TestCase
{

    public function test()
    {
        $weatherData = new WeatherDataProEvent();
        $outsideStatistics = new OutsideStatistics();
        $display = new StatisticsDisplay($outsideStatistics);
        $onChangeTemperature = function (WeatherDataProEvent $weatherData) use ($display) {
            $display->onChangeTemperature($weatherData->getTemperature());
        };

        $onChangePressure = function (WeatherDataProEvent $weatherData) use ($display) {
            $display->onChangePressure($weatherData->getPressure());
        };

        $weatherData->subscribe(Events::OUTSIDE_TEMPERATURE, $onChangeTemperature);
        $weatherData->subscribe(Events::OUTSIDE_PRESSURE, $onChangePressure);

        $this->assertEquals(null, $outsideStatistics->getTemperatureStatistics()->getAvg());
        $this->assertEquals(null, $outsideStatistics->getPressureStatistics()->getAvg());
        $weatherData->setMeasurements(15, 0.65, 750, 20, 270);
        $this->assertEquals(15, $outsideStatistics->getTemperatureStatistics()->getAvg());
        $this->assertEquals(750, $outsideStatistics->getPressureStatistics()->getAvg());

        $weatherData->unsubscribe(Events::OUTSIDE_TEMPERATURE, $onChangeTemperature);
        $weatherData->setMeasurements(25, 0.65, 760, 20, 270);
        $this->assertEquals(15, $outsideStatistics->getTemperatureStatistics()->getAvg());
        $this->assertEquals(755, $outsideStatistics->getPressureStatistics()->getAvg());

        $weatherData->removeEventListener($onChangePressure);
        $weatherData->setMeasurements(-30, 0.65, 740, 20, 270);
        $this->assertEquals(15, $outsideStatistics->getTemperatureStatistics()->getAvg());
        $this->assertEquals(755, $outsideStatistics->getPressureStatistics()->getAvg());


    }

    public function testPriority()
    {
        $weatherData = new WeatherDataProEvent();
        $notifiedList = new NotifiedList();
        $a = function () use ($notifiedList) {
            $notifiedList->add('a');
        };

        $b = function () use ($notifiedList) {
            $notifiedList->add('b');
        };

        $c = function () use ($notifiedList) {
            $notifiedList->add('c');
        };

        $weatherData->subscribe(Events::OUTSIDE_TEMPERATURE, $a, 2);
        $weatherData->subscribe(Events::OUTSIDE_TEMPERATURE, $b, 3);
        $weatherData->subscribe(Events::OUTSIDE_TEMPERATURE, $c, 1);

        $list = ['b', 'a', 'c'];
        $weatherData->setMeasurements(15, 0.65, 750, 20, 270);
        $this->assertEquals($list, $notifiedList->getList());
    }
}