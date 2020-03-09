<?php
declare(strict_types=1);

namespace Lab08\MultiGumballMachine\Context;

interface GumballMachineInterface
{
    public function insertQuarter(): void;

    public function ejectQuarter(): void;

    public function turnCrank(): void;

    public function refill(int $count): void;

    public function about(): void;
}