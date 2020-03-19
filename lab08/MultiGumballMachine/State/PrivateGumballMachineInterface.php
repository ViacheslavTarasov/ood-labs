<?php
declare(strict_types=1);

namespace Lab08\MultiGumballMachine\State;

interface PrivateGumballMachineInterface
{
    public function setSoldOutState(): void;

    public function setNoQuarterState(): void;

    public function setSoldState(): void;

    public function setHasQuarterState(): void;

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