<?php


namespace Lab02\WeatherStationEvent;

class Events
{
    const INSIDE_TEMPERATURE = 101;
    const INSIDE_PRESSURE = 102;
    const INSIDE_HUMIDITY = 103;

    const OUTSIDE_TEMPERATURE = 201;
    const OUTSIDE_PRESSURE = 202;
    const OUTSIDE_HUMIDITY = 203;
    const OUTSIDE_WIND_SPEED = 204;
    const OUTSIDE_WIND_DIRECTION = 205;

    const AVAILABLE_CODES = [201, 202, 203, 204, 205];
}