<?php


namespace Lab03\Beverage;


class Milkshake extends BeverageWithSize
{
    public function __construct(string $size)
    {
        parent::__construct(
            $size,
            'milkshake',
            [
                Size::SMALL => 50,
                Size::MEDIUM => 60,
                Size::LARGE => 80
            ]);
    }
}