<?php
declare(strict_types=1);

namespace Lab03\Stream;

class FileInputStream implements InputDataStreamInterface
{
    private $file;

    public function __construct(string $fileName)
    {
        if (!file_exists($fileName)) {
            throw new \RuntimeException('File not exists');
        }
        $this->file = fopen($fileName, 'rb');
    }

    public function readByte(): string
    {
        return $this->readBlock(1);
    }

    public function readBlock(int $length): string
    {
        $data = fread($this->file, $length);
        if ($data === false) {
            throw new \RuntimeException('Read file error');
        }
        return $data;
    }

    public function isEof(): bool
    {
        return feof($this->file);
    }
}