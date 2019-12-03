<?php

use Lab02\WeatherStation\WeatherData;
use Lab02\WeatherStationPro\WeatherDataPro;
use Lab02\WeatherStationProDuo\StatisticsDisplayProDuo;

require_once(__DIR__ . '/../vendor/autoload.php');

$weatherDataIn = new WeatherData();
$weatherDataOut = new WeatherDataPro();
$statisticsDisplayIn = new StatisticsDisplayProDuo($weatherDataIn, $weatherDataOut);


$weatherDataIn->setMeasurements(23, 0.7, 755);
$weatherDataOut->setMeasurements(2, 0.8, 753, 14, 0);

$weatherDataIn->setMeasurements(21, 0.8, 753);
$weatherDataOut->setMeasurements(-1, 0.8, 753, 12, 90);
