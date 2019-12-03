<?php

use Lab02\WeatherStationPro\StatisticsDisplayPro;
use Lab02\WeatherStationPro\WeatherDataPro;

require_once(__DIR__ . '/../vendor/autoload.php');

$weatherDataPro = new WeatherDataPro();
$statisticsDisplayIn = new StatisticsDisplayPro($weatherDataPro);


$weatherDataPro->setMeasurements(23, 0.7, 755, 10, 0);
$weatherDataPro->setMeasurements(2, 0.8, 753, 14, 90);

$weatherDataPro->setMeasurements(21, 0.8, 753, 14, 60);
$weatherDataPro->setMeasurements(-1, 0.8, 753, 12, 250);
