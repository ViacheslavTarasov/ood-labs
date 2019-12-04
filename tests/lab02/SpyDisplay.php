<?php

namespace Tests\Lab02;

use Lab02\Common\ObservableInterface;
use Lab02\Common\ObserverInterface;

class SpyDisplay implements ObserverInterface
{
    private $notifiedList;
    private $name;

    public function __construct(NotifiedList $notifiedList, string $name)
    {
        $this->notifiedList = $notifiedList;
        $this->name = $name;
    }

    public function update(ObservableInterface $observable)
    {
        $this->notifiedList->add($this->name);
    }
}