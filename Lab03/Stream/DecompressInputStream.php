<?php
declare(strict_types=1);

namespace Lab03\Stream;

class DecompressInputStream extends InputStreamDecorator
{
    private $unpacked = [];

    public function readBlock(int $length): string
    {
        $block = '';
        for ($i = 0; $i < $length; $i++) {
            $block .= $this->readByte();
        }
        return $block;
    }

    public function readByte(): string
    {
        if ($this->unpacked) {
            return $this->extractFirstFromUnpacked();
        }
        $byte = $this->getInputDataStream()->readByte();
        if ($byte !== '') {
            $count = unpack('C', $byte)[1] ?? 0;
            $byte = unpack('a', $this->getInputDataStream()->readByte())[1] ?? '';
            $this->unpacked[] = ['byte' => $byte, 'count' => $count];
            return $this->extractFirstFromUnpacked();
        }
        return '';
    }

    private function extractFirstFromUnpacked(): string
    {
        if ($this->unpacked[0]['count']) {
            $byte = $this->unpacked[0]['byte'];
            $this->unpacked[0]['count']--;
        }
        if ($this->unpacked[0]['count'] === 0) {
            array_shift($this->unpacked);
        }
        return $byte ?? '';
    }

    public function isEof(): bool
    {
        return $this->getInputDataStream()->isEof() && !$this->unpacked;
    }
}