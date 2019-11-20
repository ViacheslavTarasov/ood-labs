<?php

namespace SimUDuck\Behavior;


class Quack implements QuackBehavior
{
    public function quack()
    {
        echo 'Quack' . PHP_EOL;
    }

}