<?php


namespace Lab03\Beverage\Coffee;

use Lab03\Beverage\Beverage;
use Lab03\Beverage\Size;

class Cappuccino extends Beverage
{
    public function getPrices(): array
    {
        return [
            Size::STANDARD => 90,
            Size::DOUBLE => 130
        ];
    }

    protected function getName(): string
    {
        return 'cappuccino';
    }
}