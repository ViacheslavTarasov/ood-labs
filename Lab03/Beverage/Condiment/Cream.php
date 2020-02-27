<?php
declare(strict_types=1);

namespace Lab03\Beverage\Condiment;

use Lab03\Beverage\CondimentDecorator;

class Cream extends CondimentDecorator
{
    protected function getCondimentDescription(): string
    {
        return 'cream';
    }

    protected function getCondimentCost(): float
    {
        return 25;
    }

}