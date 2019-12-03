<?php

use Lab02\WeatherStationEvent\Events;
use Lab02\WeatherStationEvent\StatisticsDisplay;
use Lab02\WeatherStationEvent\WeatherData;

require_once(__DIR__ . '/../vendor/autoload.php');


$weatherData = new WeatherData();

$statisticsDisplay = new StatisticsDisplay($weatherData);

$weatherData->setMeasurements(23, 0.7, 755, 20, 155);
$weatherData->setMeasurements(23, 0.8, 755, 15, 160);
$weatherData->setMeasurements(30, 0.8, 740, 15, 160);
$weatherData->unsubscribeObserver($statisticsDisplay, Events::OUTSIDE_TEMPERATURE);
$weatherData->setMeasurements(-30, 0.8, 740, 15, 160);
$weatherData->setMeasurements(-40, 0.8, 740, 15, 160);
$weatherData->setMeasurements(-50, 0.8, 740, 15, 160);
