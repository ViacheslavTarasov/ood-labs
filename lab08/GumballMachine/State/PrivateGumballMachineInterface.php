<?php
declare(strict_types=1);

namespace Lab08\GumballMachine\State;

interface PrivateGumballMachineInterface
{
    public function setSoldOutState(): void;

    public function setNoQuarterState(): void;

    public function setSoldState(): void;

    public function setHasQuarterState(): void;

    public function releaseBall(): void;

    public function getBallCount(): int;
}