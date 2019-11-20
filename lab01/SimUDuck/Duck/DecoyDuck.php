<?php

namespace SimUDuck\Duck;


use SimUDuck\Behavior\DanceNoWay;
use SimUDuck\Behavior\FlyNoWay;
use SimUDuck\Behavior\MuteQuack;

class DecoyDuck extends Duck
{
    public function __construct()
    {
        $this->setFlyBehavior(new FlyNoWay());
        $this->setQuackBehavior(new MuteQuack());
        $this->setDanceBehavior(new DanceNoWay());
    }

    public function display()
    {
        echo 'I am DecoyDuck' . PHP_EOL;

    }
}