<?php

namespace Lab02\WeatherStationEvent;

interface Observer
{
    public function update(Observable $observable);
}