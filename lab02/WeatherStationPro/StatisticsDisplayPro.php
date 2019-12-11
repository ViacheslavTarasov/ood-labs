<?php


namespace Lab02\WeatherStationPro;

use Lab02\Common\ObservableInterface;
use Lab02\Common\ObserverInterface;
use Lab02\Common\OutsideStatistics;
use Lab02\Common\PrintHelper;

class StatisticsDisplayPro implements ObserverInterface
{
    private $outsideStatistics;
    private $printHelper;

    public function __construct(WeatherDataPro $weatherData, OutsideStatistics $outsideStatistics)
    {
        $weatherData->registerObserver($this);
        $this->outsideStatistics = $outsideStatistics;
        $this->printHelper = new PrintHelper();
    }

    public function update(ObservableInterface $observable)
    {
        if ($observable instanceof WeatherDataPro) {
            $this->outsideStatistics->addTemperature($observable->getTemperature());
            $this->outsideStatistics->addHumidity($observable->getHumidity());
            $this->outsideStatistics->addPressure($observable->getPressure());
            $this->outsideStatistics->addWindSpeed($observable->getWindSpeed());
            $this->outsideStatistics->addWindDirection($observable->getWindDirection());

            $this->display();
        }

    }

    public function display()
    {
        $this->printHelper->printStatistics('temperature', $this->outsideStatistics->getTemperatureStatistics());
        $this->printHelper->printStatistics('humidity', $this->outsideStatistics->getHumidityStatistics());
        $this->printHelper->printStatistics('pressure', $this->outsideStatistics->getPressureStatistics());
        $this->printHelper->printStatistics('wind speed', $this->outsideStatistics->getWindSpeedStatistics());
        $this->printHelper->printWindDirectionStat('wind direction', $this->outsideStatistics->getWindDirectionStatistics());
        echo PHP_EOL;
    }
}