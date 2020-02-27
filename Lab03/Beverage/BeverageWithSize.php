<?php
declare(strict_types=1);

namespace Lab03\Beverage;

abstract class BeverageWithSize implements BeverageInterface
{
    private $size;
    private $name;
    private $prices;

    /**
     * BeverageWithSize constructor.
     * @param string $size
     * @param string $name
     * @param array $prices
     * @throws NotOnSaleException
     */
    public function __construct(string $size, string $name, array $prices)
    {
        $this->size = $size;
        $this->name = $name;
        $this->prices = $prices;
        if (!in_array($size, array_keys($this->prices))) {
            throw new NotOnSaleException($this->getDescription() . ' not on sale');
        }
    }


    public function getDescription(): string
    {
        return $this->size . ' ' . $this->name;
    }

    public function getCost(): float
    {
        return $this->prices[$this->size];
    }
}