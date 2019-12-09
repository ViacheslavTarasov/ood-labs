<?php

namespace Lab02\WeatherStationProEvent;

interface ObservableEventInterface
{
    public function subscribeObserver(ObserverInterface $observer, string $event, int $priority);

    public function unsubscribeObserver(ObserverInterface $observer, string $event);

    public function notifyObservers(string $event);

    public function removeObserver(ObserverInterface $observer);
}