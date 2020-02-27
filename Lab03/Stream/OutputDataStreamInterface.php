<?php
declare(strict_types=1);

namespace Lab03\Stream;


interface OutputDataStreamInterface
{
    public function writeByte(string $data): void;

    public function writeBlock(string $data, int $length): void;
}