<?php


namespace Lab02\WeatherStationProEvent;


use Lab02\Common\OutsideStatistics;
use Lab02\Common\PrintHelper;

class StatisticsDisplay
{
    private $outsideStatistics;
    private $printHelper;

    public function __construct(
        OutsideStatistics $outsideStatistics
    )
    {
        $this->outsideStatistics = $outsideStatistics;
        $this->printHelper = new PrintHelper();
    }

    public function onChangeTemperature(float $temperature)
    {
        $this->outsideStatistics->addTemperature($temperature);
        $this->display();
    }

    public function onChangePressure(float $pressure)
    {
        $this->outsideStatistics->addPressure($pressure);
        $this->display();
    }

    public function display()
    {
        $this->printHelper->printStatistics('temperature', $this->outsideStatistics->getTemperatureStatistics());
        $this->printHelper->printStatistics('pressure', $this->outsideStatistics->getPressureStatistics());
        echo PHP_EOL;
    }
}