<?php


namespace Lab03\Beverage\Condiment;


class NutLiquor extends Liquor
{
    protected function getCondimentDescription(): string
    {
        return 'nut liquor';
    }
}