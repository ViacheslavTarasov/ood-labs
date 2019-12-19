<?php

namespace Lab03\Beverage\Condiment;

class ChocolateLiquor extends Liquor
{
    protected function getCondimentDescription(): string
    {
        return 'chocolate liquor';
    }
}