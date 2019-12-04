<?php

use Lab02\Common\InsideStatistics;
use Lab02\Common\OutsideStatistics;
use Lab02\WeatherStation\WeatherData;
use Lab02\WeatherStationPro\WeatherDataPro;
use Lab02\WeatherStationProDuo\StatisticsDisplayProDuo;

require_once(__DIR__ . '/../vendor/autoload.php');

$weatherDataIn = new WeatherData();
$weatherDataOut = new WeatherDataPro();
$insideStatistics = new InsideStatistics();
$outsideStatistics = new OutsideStatistics();
$statisticsDisplayIn = new StatisticsDisplayProDuo($weatherDataIn, $weatherDataOut, $insideStatistics, $outsideStatistics);


$weatherDataIn->setMeasurements(23, 0.7, 755);
$weatherDataOut->setMeasurements(2, 0.8, 753, 14, 0);

$weatherDataIn->setMeasurements(21, 0.8, 753);
$weatherDataOut->setMeasurements(-1, 0.8, 753, 12, 90);
