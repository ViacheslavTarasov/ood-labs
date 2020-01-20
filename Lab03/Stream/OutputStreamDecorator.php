<?php

namespace Lab03\Stream;


abstract class OutputStreamDecorator implements OutputDataStreamInterface
{
    /** @var OutputDataStreamInterface */
    private $outputDataStream;

    public function __construct(OutputDataStreamInterface $outputDataStream)
    {
        $this->outputDataStream = $outputDataStream;
    }

    protected function getOutputDataStream(): OutputDataStreamInterface
    {
        return $this->outputDataStream;
    }

    abstract function writeByte(string $data): void;

    abstract function writeBlock(string $data, int $length): void;

}