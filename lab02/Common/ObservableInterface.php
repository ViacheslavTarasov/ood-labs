<?php

namespace Lab02\Common;

interface ObservableInterface
{
    public function registerObserver(ObserverInterface $observer, int $priority = 0);

    public function notifyObservers();

    public function removeObserver(ObserverInterface $observer);
}