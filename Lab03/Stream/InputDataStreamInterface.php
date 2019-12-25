<?php

namespace Lab03\Stream;

interface InputDataStreamInterface
{
    public function readByte($handle): string;

    public function readBlock($handle, int $length): string;

    public function isEof($handle): bool;

}