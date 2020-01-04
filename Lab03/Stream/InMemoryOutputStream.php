<?php

namespace Lab03\Stream;

class InMemoryOutputStream implements OutputDataStreamInterface
{
    private $data = '';

    public function writeByte($data): void
    {
        $this->writeBlock($data, 1);
    }

    public function writeBlock($data, int $length): void
    {
        $this->data .= substr($data, 0, $length);
    }

    public function getData(): string
    {
        return $this->data;
    }
}