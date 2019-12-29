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

    public function getOutputDataStream(): OutputDataStreamInterface
    {
        return $this->outputDataStream;
    }

    abstract function writeByte($data): void;

    abstract function writeBlock($data, int $length): void;

}