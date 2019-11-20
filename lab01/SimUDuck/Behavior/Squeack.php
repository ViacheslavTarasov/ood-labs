<?php

namespace SimUDuck\Behavior;


class Squeack implements QuackBehavior
{
    public function quack()
    {
        echo 'Squeack' . PHP_EOL;
    }

}