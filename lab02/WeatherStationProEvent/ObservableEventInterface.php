<?php

namespace Lab02\WeatherStationProEvent;

interface ObservableEventInterface
{
    public function subscribeObserver(ObserverInterface $observer, int $event, int $priority);

    public function unsubscribeObserver(ObserverInterface $observer, int $event);

    public function notifyObservers(int $event);

    public function removeObserver(ObserverInterface $observer);
}