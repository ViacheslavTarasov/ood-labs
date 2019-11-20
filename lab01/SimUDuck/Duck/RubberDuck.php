<?php

namespace SimUDuck\Duck;


use SimUDuck\Behavior\DanceNoWay;
use SimUDuck\Behavior\FlyNoWay;
use SimUDuck\Behavior\Squeack;

class RubberDuck extends Duck
{
    public function __construct()
    {
        $this->setFlyBehavior(new FlyNoWay());
        $this->setQuackBehavior(new Squeack());
        $this->setDanceBehavior(new DanceNoWay());
    }

    public function display()
    {
        echo 'I am RubberDuck' . PHP_EOL;

    }
}