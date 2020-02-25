<?php
declare(strict_types=1);

namespace Lab08\MultiGumballMachine\Context;

class State
{
    public const SOLD_OUT = 'sold out';
    public const SOLD = 'sold';
    public const NO_QUARTER = 'no quarter';
    public const HAS_QUARTER = 'has_quarter';
}