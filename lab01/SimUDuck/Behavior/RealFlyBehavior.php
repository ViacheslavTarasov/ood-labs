<?php


namespace SimUDuck\Behavior;


abstract class RealFlyBehavior implements FlyBehavior
{

    protected $amountFights = 0;

    public function fly()
    {
        echo 'fly #' . ++$this->amountFights . PHP_EOL;
    }

}