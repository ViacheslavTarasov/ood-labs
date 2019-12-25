<?php

namespace Lab03\Stream;


class FileOutputStream implements OutputDataStreamInterface
{
    public function writeByte($handle, $data): void
    {
        $this->writeBlock($handle, $data, 1);
    }

    public function writeBlock($handle, $data, int $length): void
    {
        $this->exceptionIfNotResource($handle);
        $result = fwrite($handle, $data, $length);
        if ($result === false) {
            throw new \RuntimeException('write file error');
        }
    }

    private function exceptionIfNotResource($res)
    {
        if (!is_resource($res)) {
            throw new \RuntimeException('is not resource');
        }
    }

}