<?php


namespace Lab03\Beverage;


class Milkshake extends Beverage
{
    public function getPrices(): array
    {
        return [
            Size::SMALL => 50,
            Size::MEDIUM => 60,
            Size::LARGE => 80
        ];
    }

    protected function getName(): string
    {
        return 'milkshake';
    }
}