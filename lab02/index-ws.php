<?php

use Lab02\Common\InsideStatistics;
use Lab02\WeatherStation\CurrentConditionDisplay;
use Lab02\WeatherStation\StatisticsDisplay;
use Lab02\WeatherStation\WeatherData;

require_once(__DIR__ . '/../vendor/autoload.php');


$weatherData = new WeatherData();
$currentConditionDisplay = new CurrentConditionDisplay($weatherData);
$insideStatistics = new InsideStatistics();
$statisticsDisplay = new StatisticsDisplay($weatherData, $insideStatistics);

$weatherData->setMeasurements(23, 0.7, 755);
$weatherData->setMeasurements(21, 0.8, 753);

$weatherData->removeObserver($statisticsDisplay);

$weatherData->setMeasurements(2, 0.8, 753);
$weatherData->setMeasurements(-1, 0.8, 753);
