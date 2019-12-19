<?php

namespace Lab03\Beverage\Condiment;

use Lab03\Beverage\CondimentDecorator;


abstract class Liquor extends CondimentDecorator
{
    protected function getCondimentCost(): float
    {
        return 50;
    }

}