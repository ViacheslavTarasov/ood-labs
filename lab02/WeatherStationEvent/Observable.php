<?php

namespace Lab02\WeatherStationEvent;

interface Observable
{
    public function subscribeObserver(Observer $observer, int $event, int $priority);

    public function unsubscribeObserver(Observer $observer, int $event);

    public function notifyObservers(int $event);

    public function removeObserver(Observer $observer);
}