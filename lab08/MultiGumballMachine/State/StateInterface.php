<?php
declare(strict_types=1);

namespace Lab08\MultiGumballMachine\State;

interface StateInterface
{
    public function insertQuarter(): void;

    public function ejectQuarter(): void;

    public function turnCrank(): void;

    public function dispense(): void;

    public function refill(int $count): void;

    public function toString(): string;
}