<?php

namespace Lab03\Stream;


interface OutputDataStreamInterface
{
    public function writeByte($handle, $data): void;

    public function writeBlock($handle, $data, int $length): void;
}