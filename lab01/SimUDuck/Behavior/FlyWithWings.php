<?php

namespace SimUDuck\Behavior;


class FlyWithWings extends RealFlyBehavior implements FlyBehavior
{
    public function fly()
    {
        parent::fly();
        echo 'FlyWithWings' . PHP_EOL;
    }
}