<?php

namespace Lab03\Stream;


abstract class OutputStreamDecorator implements OutputDataStreamInterface
{
    /** @var OutputDataStreamInterface */
    protected $outputDataStream;

    public function __construct(OutputDataStreamInterface $outputDataStream)
    {
        $this->outputDataStream = $outputDataStream;
    }

    abstract function writeByte($handle, $data): void;

    abstract function writeBlock($handle, $data, int $length): void;

}