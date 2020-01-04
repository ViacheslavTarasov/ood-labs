<?php

namespace Lab03\Stream;

class DecompressInputStream extends InputStreamDecorator
{
    private $unpacked = [];

    public function __construct(InputDataStreamInterface $inputDataStream)
    {
        parent::__construct($inputDataStream);
    }

    public function readBlock(int $length): string
    {
        $block = '';
        for ($i = 0; $i < $length; $i++) {
            $block .= $this->readByte();
        }
        while ($this->unpacked) {
            $block .= $this->extractFirstFromUnpacked();
        }
        return $block;
    }

    public function readByte(): string
    {
        $byte = $this->getInputDataStream()->readByte();
        if ($byte !== '') {
            $count = unpack('C', $byte)[1] ?? 0;
            $byte = unpack('a', $this->getInputDataStream()->readByte())[1] ?? '';
            $this->unpacked[] = ['byte' => $byte, 'count' => $count];
        }
        $data = '';
        while ($this->unpacked) {
            $data .= $this->extractFirstFromUnpacked();
        }
        return $data;
    }

    private function extractFirstFromUnpacked()
    {
        if ($this->unpacked[0]['count']) {
            $byte = $this->unpacked[0]['byte'];
            $this->unpacked[0]['count']--;
        }
        if ($this->unpacked[0]['count'] === 0) {
            array_shift($this->unpacked);
        }
        return $byte ?? null;
    }

    public function isEof(): bool
    {
        return $this->getInputDataStream()->isEof() && !$this->unpacked;
    }
}