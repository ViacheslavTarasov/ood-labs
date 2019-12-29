<?php

namespace Lab03\Stream;


interface OutputDataStreamInterface
{
    public function writeByte($data): void;

    public function writeBlock($data, int $length): void;
}