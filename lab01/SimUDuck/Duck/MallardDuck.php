<?php

namespace SimUDuck\Duck;

use SimUDuck\Behavior\FlyWithWings;
use SimUDuck\Behavior\Quack;
use SimUDuck\Behavior\WaltzDance;

class MallardDuck extends Duck
{

    public function __construct()
    {
        $this->setFlyBehavior(new FlyWithWings());
        $this->setQuackBehavior(new Quack());
        $this->setDanceBehavior(new WaltzDance());
    }

    public function display()
    {
        echo 'I am MallardDuck' . PHP_EOL;
    }

}