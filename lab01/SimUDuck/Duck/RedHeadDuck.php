<?php

namespace SimUDuck\Duck;


use SimUDuck\Behavior\FlyWithWings;
use SimUDuck\Behavior\MinuetDance;
use SimUDuck\Behavior\Quack;

class RedHeadDuck extends Duck
{

    public function __construct()
    {
        $this->setFlyBehavior(new FlyWithWings());
        $this->setQuackBehavior(new Quack());
        $this->setDanceBehavior(new MinuetDance());
    }

    public function display()
    {
        echo 'I am RedHeadDuck' . PHP_EOL;
    }

}