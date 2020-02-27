<?php
declare(strict_types=1);

namespace Lab03\Beverage\Tea;

use Lab03\Beverage\Tea;

class IvanTea extends Tea
{
    public function getDescription(): string
    {
        return 'ivan tea';
    }
}