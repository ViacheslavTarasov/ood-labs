<?php

use Lab02\Common\OutsideStatistics;
use Lab02\WeatherStationProEvent\Events;
use Lab02\WeatherStationProEvent\StatisticsDisplay;
use Lab02\WeatherStationProEvent\WeatherDataProEvent;

require_once(__DIR__ . '/../vendor/autoload.php');


$weatherData = new WeatherDataProEvent();
$outsideStatistics = new OutsideStatistics();
$display = new StatisticsDisplay($outsideStatistics, $weatherData);

$weatherData->setMeasurements(23, 0.7, 755, 20, 155);
$weatherData->setMeasurements(23, 0.8, 755, 15, 160);
$weatherData->setMeasurements(30, 0.8, 740, 15, 160);
$weatherData->unsubscribe(Events::OUTSIDE_TEMPERATURE, $display->getOnTemperatureChangeCallback());
$weatherData->setMeasurements(-30, 0.8, 730, 15, 160);
$weatherData->setMeasurements(-40, 0.8, 740, 15, 160);
$weatherData->setMeasurements(-50, 0.8, 740, 15, 160);
$weatherData->removeEventListener($display->getOnPressureChangeCallback());
$weatherData->setMeasurements(-50, 0.8, 760, 15, 160);
$weatherData->setMeasurements(-50, 0.8, 770, 15, 160);

