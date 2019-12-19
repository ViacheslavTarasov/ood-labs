<?php

namespace Lab03\Beverage;

abstract class Beverage implements BeverageInterface
{
    protected $size;

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

    abstract protected function getPrices(): array;

    public function getDescription(): string
    {
        return $this->size . ' ' . $this->getName();
    }

    abstract protected function getName(): string;

    public function getCost(): float
    {
        return $this->getPrices()[$this->size];
    }
}