<?php
declare(strict_types=1);

namespace Lab08\MultiGumballMachine\Context;

interface PrivateGumballMachineInterface
{
    public function setSoldOutState(): void;

    public function setNoQuarterState(): void;

    public function setSoldState(): void;

    public function setHasQuarterState(): void;

    public function insertQuarter(): void;

    public function ejectQuarter(): void;

    public function turnCrank(): void;

    public function releaseBall(): void;

    public function getBallCount(): int;

    public function setBallCount(int $count): void;

    public function addQuarter(): void;

    public function isMaxQuarterCountReached(): bool;

    public function getQuarterCount(): int;

    public function returnQuartersCount(): void;

    public function refill(int $count): void;

    public function toString(): string;
}