<?php
declare(strict_types=1);

namespace Lab03\Stream;

interface InputDataStreamInterface
{
    public function readByte(): string;

    public function readBlock(int $length): string;

    public function isEof(): bool;

}