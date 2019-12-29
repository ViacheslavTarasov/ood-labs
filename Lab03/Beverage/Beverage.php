<?php

namespace Lab03\Beverage;

abstract class Beverage implements BeverageInterface
{
    private $size;

    /**
     * Beverage constructor.
     * @param string $size
     * @throws NotOnSaleException
     */
    public function __construct(string $size)
    {
        if (!in_array($size, $this->getAvailableSizes())) {
            throw new NotOnSaleException($this->getDescription() . ' not on sale');
        }
        $this->size = $size;
    }

    public function getAvailableSizes()
    {
        return array_keys($this->getPrices());
    }

    public function getDescription(): string
    {
        return $this->size . ' ' . $this->getName();
    }

    public function getCost(): float
    {
        return $this->getPrices()[$this->size];
    }

    abstract protected function getName(): string;

    abstract protected function getPrices(): array;
}