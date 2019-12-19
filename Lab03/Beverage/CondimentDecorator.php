<?php

namespace Lab03\Beverage;

abstract class CondimentDecorator implements BeverageInterface
{
    private $beverage;

    public function __construct(BeverageInterface $beverage)
    {
        $this->beverage = $beverage;
    }

    public function getDescription(): string
    {
        return $this->beverage->getDescription() . ', ' . $this->getCondimentDescription();
    }

    abstract protected function getCondimentDescription(): string;

    public function getCost(): float
    {
        return $this->beverage->getCost() + $this->getCondimentCost();
    }

    abstract protected function getCondimentCost(): float;
}