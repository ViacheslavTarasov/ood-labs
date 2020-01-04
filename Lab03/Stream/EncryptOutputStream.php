<?php

namespace Lab03\Stream;

class EncryptOutputStream extends OutputStreamDecorator
{
    private $encryptionService;

    public function __construct(OutputDataStreamInterface $outputDataStream, int $key)
    {
        parent::__construct($outputDataStream);
        $this->encryptionService = new EncryptionService($key);
    }

    public function writeByte($data): void
    {
        $this->getOutputDataStream()->writeByte($this->encryptionService->encrypt($data));
    }

    public function writeBlock($data, int $length): void
    {
        for ($i = 0; $i < strlen($data); $i++) {
            $data[$i] = $this->encryptionService->encrypt($data[$i]);
        }

        $this->getOutputDataStream()->writeBlock($data, $length);
    }
}