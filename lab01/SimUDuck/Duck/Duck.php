<?php

namespace SimUDuck\Duck;


use SimUDuck\Behavior\DanceBehavior;
use SimUDuck\Behavior\FlyBehavior;
use SimUDuck\Behavior\QuackBehavior;

abstract class Duck
{
    /** @var DanceBehavior */
    protected $danceBehavior;
    /** @var FlyBehavior */
    protected $flyBehavior;
    /** @var QuackBehavior */
    protected $quackBehavior;

    public function setDanceBehavior(DanceBehavior $danceBehavior)
    {
        $this->danceBehavior = $danceBehavior;
    }

    public function setFlyBehavior(FlyBehavior $flyBehavior)
    {
        $this->flyBehavior = $flyBehavior;
    }

    public function setQuackBehavior(QuackBehavior $quackBehavior)
    {
        $this->quackBehavior = $quackBehavior;
    }

    public function performDance()
    {
        $this->danceBehavior->dance();
    }

    public function performFly()
    {
        $this->flyBehavior->fly();
    }

    public function performQuack()
    {
        $this->quackBehavior->quack();
    }

    public function swim()
    {
        echo 'I am swim' . PHP_EOL;
    }

    abstract public function display();
}