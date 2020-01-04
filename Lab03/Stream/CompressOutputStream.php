<?php

namespace Lab03\Stream;

class CompressOutputStream extends OutputStreamDecorator
{
    private $count = 0;
    private $current;

    public function __construct(OutputDataStreamInterface $outputDataStream)
    {
        parent::__construct($outputDataStream);
    }

    public function writeBlock($data, int $length): void
    {
        $length = strlen($data) < $length ? strlen($data) : $length;
        if (!$length) {
            $this->writeByte('');
            return;
        }
        for ($i = 0; $i < $length; $i++) {
            $this->writeByte($data[$i]);
        }
    }

    public function writeByte($data): void
    {
        if (is_null($this->current)) {
            $this->current = $data;
        } elseif ($this->current != $data || $this->count >= 255) {
            $block = pack('Ca', $this->count, $this->current);
            $this->getOutputDataStream()->writeBlock($block, 2);
            $this->current = $data;
            $this->count = 0;
        }
        $this->count++;
    }
}