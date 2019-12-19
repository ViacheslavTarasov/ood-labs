<?php

namespace Lab03\Beverage\Coffee;

use Lab03\Beverage\Beverage;
use Lab03\Beverage\Size;

class Espresso extends Beverage
{
    public function getPrices(): array
    {
        return [
            Size::SMALL => 120
        ];
    }

    protected function getName(): string
    {
        return 'espresso';
    }
}