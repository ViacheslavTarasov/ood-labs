<?php

use Lab02\Common\OutsideStatistics;
use Lab02\WeatherStationPro\StatisticsDisplayPro;
use Lab02\WeatherStationPro\WeatherDataPro;

require_once(__DIR__ . '/../vendor/autoload.php');

$weatherData = new WeatherDataPro();
$outsideStatistics = new OutsideStatistics();
$statisticsDisplayIn = new StatisticsDisplayPro($weatherData, $outsideStatistics);


$weatherData->setMeasurements(23, 0.7, 755, 10, 0);
$weatherData->setMeasurements(2, 0.8, 753, 14, 90);

$weatherData->setMeasurements(21, 0.8, 753, 14, 60);
$weatherData->setMeasurements(-1, 0.8, 753, 12, 250);
