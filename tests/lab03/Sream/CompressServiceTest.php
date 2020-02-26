<?php
declare(strict_types=1);

use Lab03\Stream\CompressService;
use PHPUnit\Framework\TestCase;

class CompressServiceTest extends TestCase
{
    private const BYTE = 'a';
    private const ANOTHER_BYTE = 'b';
    /** @var CompressService */
    private $compressService;

    public function testGetPackedOrAccumulateReturnsNullIfEmptyByte(): void
    {
        $this->assertNull($this->compressService->getPackedOrAccumulate(''));
    }

    public function testGetPackedOrAccumulateReturnsNullIfOneByte(): void
    {
        $this->assertNull($this->compressService->getPackedOrAccumulate(self::BYTE));
    }

    public function testGetPackedOrAccumulateReturnsNullIfByteIsRepeated(): void
    {
        $this->assertNull($this->compressService->getPackedOrAccumulate(self::BYTE));
        $this->assertNull($this->compressService->getPackedOrAccumulate(self::BYTE));
    }

    public function testGetPackedOrAccumulateReturnsPacketStringOnlyAfterAccumulatorSizeRepeated(): void
    {
        for ($i = 0; $i < CompressService::ACCUMULATOR_SIZE; $i++) {
            $this->assertNull($this->compressService->getPackedOrAccumulate(self::BYTE));
        }

        $expectedPacked = $this->pack(CompressService::ACCUMULATOR_SIZE, self::BYTE);
        $this->assertEquals($expectedPacked, $this->compressService->getPackedOrAccumulate(self::BYTE));
    }

    private function pack(int $count, string $byte): string
    {
        return pack('Ca', $count, $byte);
    }

    public function testGetPackedOrAccumulateReturnsPackedWhenAnotherByte(): void
    {
        $this->compressService->getPackedOrAccumulate(self::BYTE);
        $this->compressService->getPackedOrAccumulate(self::BYTE);

        $bytePacked = $this->compressService->getPackedOrAccumulate(self::ANOTHER_BYTE);
        $this->assertEquals($this->pack(2, self::BYTE), $bytePacked);

        $anotherBytePacked = $this->compressService->getPackedOrAccumulate(self::BYTE);
        $this->assertEquals($this->pack(1, self::ANOTHER_BYTE), $anotherBytePacked);
    }

    protected function setUp(): void
    {
        $this->compressService = new CompressService();
    }
}
