<?php


namespace Lab02\WeatherStationProEvent;

class Events
{
    const INSIDE_TEMPERATURE = 'inside.temperature_changed';
    const INSIDE_PRESSURE = 'inside.pressure_changed';
    const INSIDE_HUMIDITY = 'inside.humidity_changed';

    const OUTSIDE_TEMPERATURE = 'outside.temperature_changed';
    const OUTSIDE_PRESSURE = 'outside.pressure_changed';
    const OUTSIDE_HUMIDITY = 'outside.humidity_changed';
    const OUTSIDE_WIND_SPEED = 'outside.wind_speed_changed';
    const OUTSIDE_WIND_DIRECTION = 'outside.wind_direction_changed';

    const AVAILABLE_CODES = [
        self::OUTSIDE_TEMPERATURE,
        self::OUTSIDE_PRESSURE,
        self::OUTSIDE_HUMIDITY,
        self::OUTSIDE_WIND_SPEED,
        self::OUTSIDE_WIND_DIRECTION,
    ];
}