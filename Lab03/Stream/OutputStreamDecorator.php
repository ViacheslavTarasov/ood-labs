<?php
declare(strict_types=1);

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

    abstract public function writeByte(string $data): void;

    abstract public function writeBlock(string $data, int $length): void;

}