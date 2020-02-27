<?php
declare(strict_types=1);

namespace Lab03\Stream;

class EncryptOutputStream extends OutputStreamDecorator
{
    private $encryptionService;

    public function __construct(OutputDataStreamInterface $outputDataStream, int $key)
    {
        parent::__construct($outputDataStream);
        $this->encryptionService = new EncryptionService($key);
    }

    public function writeByte(string $data): void
    {
        $this->getOutputDataStream()->writeByte($this->encryptionService->encrypt($data));
    }

    public function writeBlock(string $data, int $length): void
    {
        $dataLength = strlen($data);
        for ($i = 0; $i < $dataLength; $i++) {
            $data[$i] = $this->encryptionService->encrypt($data[$i]);
        }

        $this->getOutputDataStream()->writeBlock($data, $length);
    }
}