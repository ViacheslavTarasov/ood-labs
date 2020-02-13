<?php

namespace Lab05\Command\Document;

interface CommandInterface
{
    public function execute(): void;

    public function unexecute(): void;
}