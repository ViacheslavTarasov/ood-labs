<?php
declare(strict_types=1);

namespace Lab08\GumballMachine\Context;

interface GumballMachineInterface
{
    public function insertQuarter(): void;

    public function ejectQuarter(): void;

    public function turnCrank(): void;
}