<?php

require_once(__DIR__ . '/../vendor/autoload.php');

use Lab02\WeatherStation\CurrentConditionDisplay;
use Lab02\WeatherStation\StatisticsDisplay;
use Lab02\WeatherStation\WeatherData;

$weatherData = new WeatherData();
$currentConditionDisplay = new CurrentConditionDisplay($weatherData);
$statisticsDisplay = new StatisticsDisplay($weatherData);

$weatherData->setMeasurements(23, 0.7, 755);
$weatherData->setMeasurements(21, 0.8, 753);

$weatherData->removeObserver($statisticsDisplay);

$weatherData->setMeasurements(2, 0.8, 753);
$weatherData->setMeasurements(-1, 0.8, 753);
