<?php
//declare(encoding='UTF-8');

namespace Lab03\Stream;

class EncryptFileOutputStream extends OutputStreamDecorator
{
    private $map;

    public function __construct(OutputDataStreamInterface $outputDataStream, int $key)
    {
        parent::__construct($outputDataStream);
        $this->map = (new EncryptionMapGenerator())->generate($key);
    }

    public function writeByte($data): void
    {
        $this->getOutputDataStream()->writeByte($this->encrypt($data));
    }

    public function writeBlock($data, int $length): void
    {
        for ($i = 0; $i < strlen($data); $i++) {
            $data[$i] = $this->encrypt($data[$i]);
        }

        $this->getOutputDataStream()->writeBlock($data, $length);
    }

    private function encrypt(string $byte): string
    {
        $encrypted = $byte;
        if ($byte !== '') {
            $ord = ord($byte);
            $index = array_search($ord, $this->map);
            $encrypted = chr($index);
        }
        return $encrypted;
    }
}