<?php
declare(strict_types=1);

namespace Lab05\History;

interface CommandInterface
{
    public function execute(): void;

    public function unexecute(): void;
}