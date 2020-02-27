<?php
declare(strict_types=1);

namespace Lab03\Beverage\Condiment;

use InvalidArgumentException;
use Lab03\Beverage\BeverageInterface;
use Lab03\Beverage\CondimentDecorator;

class Chocolate extends CondimentDecorator
{
    public const MAX_SLICES = 5;
    private $slices;

    public function __construct(BeverageInterface $beverage, int $slices)
    {
        parent::__construct($beverage);
        if ($slices > self::MAX_SLICES) {
            throw new InvalidArgumentException('max slices is ' . self::MAX_SLICES);
        }
        $this->slices = $slices;
    }

    protected function getCondimentDescription(): string
    {
        return 'chocolate x ' . $this->slices;
    }

    protected function getCondimentCost(): float
    {
        return 10 * $this->slices;
    }

}