<?php
declare(strict_types=1);

namespace Lab03\Stream;

use RuntimeException;

class FileOutputStream implements OutputDataStreamInterface
{
    private $file;

    public function __construct(string $fileName)
    {
        $this->file = fopen($fileName, 'wb');
    }

    public function writeByte(string $data): void
    {
        $this->writeBlock($data, 1);
    }

    public function writeBlock(string $data, int $length): void
    {
        $result = fwrite($this->file, $data, $length);
        if ($result === false) {
            throw new RuntimeException('Write file error');
        }
    }
}