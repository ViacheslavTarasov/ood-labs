<?php

namespace Lab03\Stream;


abstract class InputStreamDecorator implements InputDataStreamInterface
{
    /** @var InputDataStreamInterface */
    protected $inputDataStream;

    public function __construct(InputDataStreamInterface $inputDataStream)
    {
        $this->inputDataStream = $inputDataStream;
    }

    public function isEof($handle): bool
    {
        return $this->inputDataStream->isEof($handle);
    }

    public function getInputDataStream(): InputDataStreamInterface
    {
        return $this->inputDataStream;
    }

    abstract public function readByte($handle): string;

    abstract public function readBlock($handle, int $length): string;

}