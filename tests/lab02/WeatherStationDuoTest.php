<?php


use Lab02\Common\InsideStatistics;
use Lab02\Common\OutsideStatistics;
use Lab02\WeatherStation\WeatherData;
use Lab02\WeatherStationDuo\StatisticsDisplayDuo;
use PHPUnit\Framework\TestCase;

class WeatherStationDuoTest extends TestCase
{

    public function testWeatherStationDuo()
    {
        $weatherDataIn = new WeatherData();
        $weatherDataOut = new WeatherData();

        $insideStatistics = new InsideStatistics();
        $outsideStatistics = new OutsideStatistics();
        $display = new StatisticsDisplayDuo($weatherDataIn, $weatherDataOut, $insideStatistics, $outsideStatistics);

        $weatherDataIn->setMeasurements(10, 0.5, 750);

        $this->assertEquals($insideStatistics->getTemperatureStatistics()->getAvg(), 10);
        $this->assertEquals($insideStatistics->getHumidityStatistics()->getAvg(), 0.5);
        $this->assertEquals($insideStatistics->getPressureStatistics()->getAvg(), 750);

        $this->assertEquals($outsideStatistics->getTemperatureStatistics()->getAvg(), null);
        $this->assertEquals($outsideStatistics->getHumidityStatistics()->getAvg(), null);
        $this->assertEquals($outsideStatistics->getPressureStatistics()->getAvg(), null);

        $weatherDataOut->setMeasurements(-10, 0.8, 748);

        $this->assertEquals($outsideStatistics->getTemperatureStatistics()->getAvg(), -10);
        $this->assertEquals($outsideStatistics->getHumidityStatistics()->getAvg(), 0.8);
        $this->assertEquals($outsideStatistics->getPressureStatistics()->getAvg(), 748);

        $this->assertEquals($insideStatistics->getTemperatureStatistics()->getAvg(), 10);
        $this->assertEquals($insideStatistics->getHumidityStatistics()->getAvg(), 0.5);
        $this->assertEquals($insideStatistics->getPressureStatistics()->getAvg(), 750);

    }
}




