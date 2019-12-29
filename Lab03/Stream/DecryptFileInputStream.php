<?php

namespace Lab03\Stream;

class DecryptFileInputStream extends InputStreamDecorator
{
    private $map;

    public function __construct(InputDataStreamInterface $inputDataStream, int $key)
    {
        parent::__construct($inputDataStream);
        $this->map = (new EncryptionMapGenerator())->generate($key);
    }

    public function readByte(): string
    {
        return $this->decrypt($this->getInputDataStream()->readByte());
    }

    public function readBlock(int $length): string
    {
        $block = $this->getInputDataStream()->readBlock($length);
        for ($i = 0; $i < strlen($block); $i++) {
            $block[$i] = $this->decrypt($block[$i]);
        }
        return $block;
    }

    private function decrypt(string $byte): string
    {
        $decrypted = $byte;
        if ($byte !== '') {
            $ord = ord($byte);
            $decrypted = chr($this->map[$ord]);
        }
        return $decrypted;
    }
}