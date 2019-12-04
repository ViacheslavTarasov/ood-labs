<?php

namespace Lab02\WeatherStationProEvent;

interface ObserverInterface
{
    public function update(ObservableEventInterface $observable);
}