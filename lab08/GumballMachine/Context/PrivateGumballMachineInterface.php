<?php
declare(strict_types=1);

namespace Lab08\GumballMachine\Context;

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
}