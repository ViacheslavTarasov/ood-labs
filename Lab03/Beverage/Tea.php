<?php

namespace Lab03\Beverage;

abstract class Tea implements BeverageInterface
{
    public function getCost(): float
    {
        return 50;
    }
}