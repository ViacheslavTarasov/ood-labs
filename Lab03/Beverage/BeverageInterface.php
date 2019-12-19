<?php

namespace Lab03\Beverage;


interface BeverageInterface
{
    public function getCost(): float;

    public function getDescription(): string;
}