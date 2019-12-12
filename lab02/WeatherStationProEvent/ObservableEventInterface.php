<?php

namespace Lab02\WeatherStationProEvent;

use Closure;

interface ObservableEventInterface
{
    public function subscribe(string $event, Closure $eventListener, int $priority = 0);

    public function unsubscribe(string $event, Closure $eventListener);

    public function notify(string $event);

    public function removeEventListener(Closure $eventListener);
}