<?php

namespace SimUDuckFP\Duck;


abstract class Duck
{
    /** @var \Closure */
    private $flyBehavior;
    /** @var \Closure */
    private $quackBehavior;
    /** @var \Closure */
    private $danceBehavior;

    public function __construct(\Closure $flyBehavior, \Closure $quackBehavior, \Closure $danceBehavior)
    {
        $this->setFlyBehavior($flyBehavior);
        $this->setQuackBehavior($quackBehavior);
        $this->setDanceBehavior($danceBehavior);
    }

    public function setDanceBehavior(\Closure $danceBehavior)
    {
        $this->danceBehavior = $danceBehavior;
    }

    public function setFlyBehavior(\Closure $flyBehavior)
    {
        $this->flyBehavior = $flyBehavior;
    }

    public function setQuackBehavior(\Closure $quackBehavior)
    {
        $this->quackBehavior = $quackBehavior;
    }

    public function performDance()
    {
        call_user_func($this->danceBehavior);
    }

    public function performFly()
    {
        call_user_func($this->flyBehavior);
    }

    public function performQuack()
    {
        call_user_func($this->quackBehavior);
    }

    public function swim()
    {
        echo 'I am swim' . PHP_EOL;
    }

    abstract public function display();
}