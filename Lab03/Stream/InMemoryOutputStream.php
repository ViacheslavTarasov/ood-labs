<?php
declare(strict_types=1);

namespace Lab03\Stream;

class InMemoryOutputStream implements OutputDataStreamInterface
{
    private $data = '';

    public function writeByte(string $data): void
    {
        $this->writeBlock($data, 1);
    }

    public function writeBlock(string $data, int $length): void
    {
        $this->data .= substr($data, 0, $length);
    }

    public function getData(): string
    {
        return $this->data;
    }
}