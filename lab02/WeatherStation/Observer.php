<?php

namespace Lab02\WeatherStation;

interface Observer
{
    public function update(Observable $observable);
}