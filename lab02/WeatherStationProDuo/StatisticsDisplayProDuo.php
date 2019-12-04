<?php


namespace Lab02\WeatherStationProDuo;


use Lab02\Common\DisplayInterface;
use Lab02\Common\InsideStatistics;
use Lab02\Common\ObservableInterface;
use Lab02\Common\ObserverInterface;
use Lab02\Common\OutsideStatistics;
use Lab02\Common\PrintHelper;
use Lab02\WeatherStation\WeatherData;
use Lab02\WeatherStationPro\WeatherDataPro;

class StatisticsDisplayProDuo implements ObserverInterface, DisplayInterface
{
    private $weatherDataIn;
    private $weatherDataOut;
    private $insideStatistics;
    private $outsideStatistics;
    private $printHelper;

    public function __construct(
        WeatherData $weatherDataIn,
        WeatherDataPro $weatherDataOut,
        InsideStatistics $insideStatistics,
        OutsideStatistics $outsideStatistics
    )
    {
        $this->weatherDataIn = $weatherDataIn;
        $this->weatherDataOut = $weatherDataOut;
        $weatherDataIn->registerObserver($this);
        $weatherDataOut->registerObserver($this);

        $this->insideStatistics = $insideStatistics;
        $this->outsideStatistics = $outsideStatistics;
        $this->printHelper = new PrintHelper();
    }

    public function update(ObservableInterface $observable)
    {
        if ($observable === $this->weatherDataIn) {
            $this->insideStatistics->addTemperature($observable->getTemperature());
            $this->insideStatistics->addHumidity($observable->getHumidity());
            $this->insideStatistics->addPressure($observable->getPressure());
        }

        if ($observable === $this->weatherDataOut) {
            $this->outsideStatistics->addTemperature($observable->getTemperature());
            $this->outsideStatistics->addHumidity($observable->getHumidity());
            $this->outsideStatistics->addPressure($observable->getPressure());
            $this->outsideStatistics->addWindSpeed($observable->getWindSpeed());
            $this->outsideStatistics->addWindDirection($observable->getWindDirection());
        }
        $this->display();
    }

    public function display()
    {
        echo "Inside" . PHP_EOL;
        $this->printHelper->printStatistics('temperature', $this->insideStatistics->getTemperatureStatistics());
        $this->printHelper->printStatistics('humidity', $this->insideStatistics->getHumidityStatistics());
        $this->printHelper->printStatistics('pressure', $this->insideStatistics->getPressureStatistics());
        echo "Outside" . PHP_EOL;
        $this->printHelper->printStatistics('temperature', $this->outsideStatistics->getTemperatureStatistics());
        $this->printHelper->printStatistics('humidity', $this->outsideStatistics->getHumidityStatistics());
        $this->printHelper->printStatistics('pressure', $this->outsideStatistics->getPressureStatistics());
        $this->printHelper->printStatistics('wind speed', $this->outsideStatistics->getWindSpeedStatistics());
        $this->printHelper->printWindDirectionStat('wind direction', $this->outsideStatistics->getWindDirectionStatistics());
        echo PHP_EOL;
    }

}