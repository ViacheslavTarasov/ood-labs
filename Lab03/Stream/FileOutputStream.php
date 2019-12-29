<?php

namespace Lab03\Stream;


class FileOutputStream implements OutputDataStreamInterface
{
    private $file;

    public function __construct(string $fileName)
    {
        $this->file = fopen($fileName, 'wb');
    }

    public function writeByte($data): void
    {
        $this->writeBlock($data, 1);
    }

    public function writeBlock($data, int $length): void
    {
        $result = fwrite($this->file, $data, $length);
        if ($result === false) {
            throw new \RuntimeException('Write file error');
        }
    }
}