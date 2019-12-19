<?php

use Lab03\Beverage\Coffee\Cappuccino;
use Lab03\Beverage\Condiment\Chocolate;
use Lab03\Beverage\Condiment\ChocolateLiquor;
use Lab03\Beverage\Condiment\Cream;
use Lab03\Beverage\Condiment\NutLiquor;
use Lab03\Beverage\Milkshake;
use Lab03\Beverage\Size;
use Lab03\Beverage\Tea\BlackTea;
use PHPUnit\Framework\TestCase;

class BeverageTest extends TestCase
{

    public function testMilkshake()
    {
        $milkshake = new Milkshake(Size::MEDIUM);
        $withLiquor = new ChocolateLiquor($milkshake);
        $withCream = new Cream($withLiquor);
        $withChocolate = new Chocolate($withCream, 4);
        $this->assertEquals(60 + 50 + 25 + 10 * 4, $withChocolate->getCost());
        $this->assertEquals('medium milkshake, chocolate liquor, cream, chocolate x 4', $withChocolate->getDescription());
    }

    public function testTea()
    {
        $tea = new BlackTea();
        $withLiquor = new NutLiquor($tea);
        $this->assertEquals(50 + 50, $withLiquor->getCost());
        $this->assertEquals('black tea, nut liquor', $withLiquor->getDescription());
    }

    public function testCoffee()
    {
        $coffee = new Cappuccino(Size::DOUBLE);
        $withLiquor = new ChocolateLiquor($coffee);
        $this->assertEquals(130 + 50, $withLiquor->getCost());
        $this->assertEquals('double cappuccino, chocolate liquor', $withLiquor->getDescription());
    }
}
