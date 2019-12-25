<?php

namespace Lab03\Stream;

class FileInputStream implements InputDataStreamInterface
{
    public function readByte($handle): string
    {
        return $this->readBlock($handle, 1);
    }

    public function readBlock($handle, int $length): string
    {
        $this->exceptionIfNotResource($handle);
        $data = fread($handle, $length);
        if ($data === false) {
            throw new \RuntimeException('read file error');
        }
        return $data;
    }

    public function isEof($handle): bool
    {
        $this->exceptionIfNotResource($handle);
        return feof($handle);
    }

    private function exceptionIfNotResource($res)
    {
        if (!is_resource($res)) {
            throw new \RuntimeException('is not resource');
        }
    }

}