<?php

namespace Lab02\WeatherStation;

interface Observable
{
    public function registerObserver(Observer $observer, int $number);

    public function notifyObservers();

    public function removeObserver(Observer $observer);
}