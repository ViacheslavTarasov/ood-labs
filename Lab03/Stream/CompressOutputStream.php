<?php
declare(strict_types=1);

namespace Lab03\Stream;

class CompressOutputStream extends OutputStreamDecorator
{
    /** @var CompressService */
    private $compressService;

    public function __construct(OutputDataStreamInterface $outputDataStream)
    {
        parent::__construct($outputDataStream);
        $this->compressService = new CompressService();
    }

    public function writeBlock(string $data, int $length): void
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

    public function writeByte(string $data): void
    {
        $packed = $this->compressService->getPackedOrAccumulate($data);
        if ($packed !== null) {
            $this->getOutputDataStream()->writeBlock($packed, 2);
        }
    }
}