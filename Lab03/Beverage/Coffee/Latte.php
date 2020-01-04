<?php


namespace Lab03\Beverage\Coffee;

use Lab03\Beverage\BeverageWithSize;
use Lab03\Beverage\Size;

class Latte extends BeverageWithSize
{
    public function __construct(string $size)
    {
        parent::__construct(
            $size,
            'latte',
            [
                Size::STANDARD => 90,
                Size::DOUBLE => 130
            ]);
    }
}