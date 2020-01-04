<?php

namespace Lab03\Stream;

class InMemoryInputStream implements InputDataStreamInterface
{
    private $data;
    private $pos = 0;

    public function __construct(string $data)
    {
        $this->data = $data;
    }

    public function readByte(): string
    {
        return $this->readBlock(1);
    }

    public function readBlock(int $length): string
    {
        $data = substr($this->data, $this->pos, $length);
        $this->pos += $length;
        return $data;
    }

    public function isEof(): bool
    {
        return $this->pos >= strlen($this->data);
    }
}

;