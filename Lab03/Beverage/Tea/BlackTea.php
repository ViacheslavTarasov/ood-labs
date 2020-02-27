<?php
declare(strict_types=1);

namespace Lab03\Beverage\Tea;

use Lab03\Beverage\Tea;

class BlackTea extends Tea
{
    public function getDescription(): string
    {
        return 'black tea';
    }
}