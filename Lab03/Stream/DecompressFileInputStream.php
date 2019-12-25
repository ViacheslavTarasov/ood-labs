<?php

namespace Lab03\Stream;

class DecompressFileInputStream extends InputStreamDecorator
{
    private $unpacked = [];

    public function __construct(InputDataStreamInterface $inputDataStream)
    {
        parent::__construct($inputDataStream);
    }

    public function readByte($handle): string
    {
        $byte = $this->getInputDataStream()->readByte($handle);
        if ($byte !== '') {
            $count = unpack('C', $byte)[1] ?? 0;
            $byte = unpack('a', $this->getInputDataStream()->readByte($handle))[1] ?? '';
            $this->unpacked[] = ['byte' => $byte, 'count' => $count];
        }
        if ($this->unpacked) {
            $byte = $this->extractFirstFromUnpacked();
        }
        return $byte;
    }

    public function readBlock($handle, int $length): string
    {
        $block = '';
        for ($i = 0; $i < strlen($length); $i++) {
            $block .= $this->readByte($handle);
        }
        while ($this->unpacked) {
            $block .= $this->extractFirstFromUnpacked();
        }
        return $block;
    }

    public function isEof($handle): bool
    {
        return $this->getInputDataStream()->isEof($handle) && !$this->unpacked;
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
}