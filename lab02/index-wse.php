<?php

use Lab02\Common\OutsideStatistics;
use Lab02\WeatherStationProEvent\Events;
use Lab02\WeatherStationProEvent\StatisticsDisplay;
use Lab02\WeatherStationProEvent\WeatherDataProEvent;

require_once(__DIR__ . '/../vendor/autoload.php');


$weatherData = new WeatherDataProEvent();
$outsideStatistics = new OutsideStatistics();
$statisticsDisplay = new StatisticsDisplay($weatherData, $outsideStatistics);

$weatherData->setMeasurements(23, 0.7, 755, 20, 155);
$weatherData->setMeasurements(23, 0.8, 755, 15, 160);
$weatherData->setMeasurements(30, 0.8, 740, 15, 160);
$weatherData->unsubscribeObserver($statisticsDisplay, Events::OUTSIDE_TEMPERATURE);
$weatherData->setMeasurements(-30, 0.8, 740, 15, 160);
$weatherData->setMeasurements(-40, 0.8, 740, 15, 160);
$weatherData->setMeasurements(-50, 0.8, 740, 15, 160);
