<?php


use Lab02\WeatherStation\Statistics;
use Lab02\WeatherStation\WeatherData;
use Lab02\WeatherStationDuo\StatisticsDisplayDuoTested;
use PHPUnit\Framework\TestCase;

class WeatherStationDuoTest extends TestCase
{

    public function testWeatherStationDuo()
    {
        $weatherDataIn = new WeatherData();
        $weatherDataOut = new WeatherData();

        $temperatureStatisticsIn = new Statistics();
        $humidityStatisticsIn = new Statistics();
        $pressureStatisticsIn = new Statistics();
        $temperatureStatisticsOut = new Statistics();
        $humidityStatisticsOut = new Statistics();
        $pressureStatisticsOut = new Statistics();

        $display = new StatisticsDisplayDuoTested(
            $weatherDataIn,
            $weatherDataOut,
            $temperatureStatisticsIn,
            $humidityStatisticsIn,
            $pressureStatisticsIn,
            $temperatureStatisticsOut,
            $humidityStatisticsOut,
            $pressureStatisticsOut
        );

        $weatherDataIn->setMeasurements(10, 0.5, 750);

        $this->assertEquals($temperatureStatisticsIn->getAvg(), 10);
        $this->assertEquals($humidityStatisticsIn->getAvg(), 0.5);
        $this->assertEquals($pressureStatisticsIn->getAvg(), 750);

        $this->assertEquals($temperatureStatisticsOut->getAvg(), null);
        $this->assertEquals($humidityStatisticsOut->getAvg(), null);
        $this->assertEquals($pressureStatisticsOut->getAvg(), null);

        $weatherDataOut->setMeasurements(-10, 0.8, 748);

        $this->assertEquals($temperatureStatisticsOut->getAvg(), -10);
        $this->assertEquals($humidityStatisticsOut->getAvg(), 0.8);
        $this->assertEquals($pressureStatisticsOut->getAvg(), 748);

        $this->assertEquals($temperatureStatisticsIn->getAvg(), 10);
        $this->assertEquals($humidityStatisticsIn->getAvg(), 0.5);
        $this->assertEquals($pressureStatisticsIn->getAvg(), 750);

    }
}




