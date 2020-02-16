<?php
declare(strict_types=1);

namespace Lab03\Stream;

class CompressService
{
    public const ACCUMULATOR_SIZE = 255;

    private $count = 0;
    private $current;

    /**
     * Returns a packed string if a new byte was received, or the amount of the current has reached 255
     *
     * @param string $byte
     * @return string|null
     */
    public function getPackedOrAccumulate(string $byte): ?string
    {
        if (strlen($byte) > 1) {
            throw  new \InvalidArgumentException('invalid byte size');
        }
        if ($this->current === null) {
            $this->current = $byte;
        } elseif ($this->current !== $byte || $this->count >= 255) {
            $packed = pack('Ca', $this->count, $this->current);
            $this->reset($byte);
            return $packed;
        }
        $this->count++;
        return null;
    }

    private function reset(string $byte): void
    {
        if ($byte === '') {
            $this->current = null;
            $this->count = 0;
        } else {
            $this->current = $byte;
            $this->count = 1;
        }
    }
}