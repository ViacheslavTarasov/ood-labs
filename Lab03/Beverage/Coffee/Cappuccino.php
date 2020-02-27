<?php
declare(strict_types=1);

namespace Lab03\Beverage\Coffee;

use Lab03\Beverage\BeverageWithSize;
use Lab03\Beverage\Size;

class Cappuccino extends BeverageWithSize
{
    public function __construct(string $size)
    {
        parent::__construct(
            $size,
            'cappuccino',
            [
                Size::STANDARD => 90,
                Size::DOUBLE => 130
            ]);
    }
}