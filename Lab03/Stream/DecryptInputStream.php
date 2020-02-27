<?php
declare(strict_types=1);

namespace Lab03\Stream;

class DecryptInputStream extends InputStreamDecorator
{
    private $encryptionService;

    public function __construct(InputDataStreamInterface $inputDataStream, int $key)
    {
        parent::__construct($inputDataStream);
        $this->encryptionService = new EncryptionService($key);
    }

    public function readByte(): string
    {
        return $this->encryptionService->decrypt($this->getInputDataStream()->readByte());
    }

    public function readBlock(int $length): string
    {
        $block = $this->getInputDataStream()->readBlock($length);
        $blockLength = strlen($block);
        for ($i = 0; $i < $blockLength; $i++) {
            $block[$i] = $this->encryptionService->decrypt($block[$i]);
        }
        return $block;
    }
}