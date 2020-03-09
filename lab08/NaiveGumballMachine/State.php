<?php
declare(strict_types=1);

namespace Lab08\NaiveGumballMachine;

class State
{
    public const SOLD_OUT = 'sold out';
    public const SOLD = 'sold';
    public const NO_QUARTER = 'no quarter';
    public const HAS_QUARTER = 'has_quarter';
}