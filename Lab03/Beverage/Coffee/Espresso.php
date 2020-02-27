<?php
declare(strict_types=1);

namespace Lab03\Beverage\Coffee;

use Lab03\Beverage\BeverageWithSize;
use Lab03\Beverage\Size;

class Espresso extends BeverageWithSize
{
    public function __construct(string $size)
    {
        parent::__construct(
            $size,
            'espresso',
            [
                Size::SMALL => 120
            ]);
    }
}