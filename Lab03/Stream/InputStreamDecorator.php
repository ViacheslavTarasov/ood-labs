<?php
declare(strict_types=1);

namespace Lab03\Stream;


abstract class InputStreamDecorator implements InputDataStreamInterface
{
    /** @var InputDataStreamInterface */
    private $inputDataStream;

    public function __construct(InputDataStreamInterface $inputDataStream)
    {
        $this->inputDataStream = $inputDataStream;
    }

    public function isEof(): bool
    {
        return $this->inputDataStream->isEof();
    }

    protected function getInputDataStream(): InputDataStreamInterface
    {
        return $this->inputDataStream;
    }

    abstract public function readByte(): string;

    abstract public function readBlock(int $length): string;

}