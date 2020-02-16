<?php
declare(strict_types=1);

use Lab03\Stream\CompressService;
use Lab03\Stream\DecompressInputStream;
use Lab03\Stream\InMemoryInputStream;
use PHPUnit\Framework\TestCase;

class DecompressInputStreamTest extends TestCase
{
    private const TEST_TEXT = 'tteeeeeest ttttttttttttttttttttext';
    private const READ_BLOCK_LENGTH = 5;
    private const READ_BLOCK_TEXT = 'tteee';

    /** @var DecompressInputStream */
    private $decompressInputStream;
    private $compressed;
    /** @var CompressService */
    private $compressService;


    public function testReadByteReturnsEmptyString(): void
    {
        $decompressInputStream = $this->getDecompressInputStream('');
        $this->assertEquals('', $decompressInputStream->readByte());
    }

    public function testReadByteReturnsStringOneCharLong(): void
    {
        $decompressInputStream = $this->getDecompressInputStream(self::TEST_TEXT);
        $this->assertEquals(1, strlen($decompressInputStream->readByte()));
    }

    public function testSuccessivelyReadByte(): void
    {
        $decompressInputStream = $this->getDecompressInputStream(self::TEST_TEXT);
        $length = strlen(self::TEST_TEXT);
        for ($i = 0; $i < $length; $i++) {
            $this->assertEquals(self::TEST_TEXT[$i], $decompressInputStream->readByte());
        }
    }

    public function testReadBlockReturnsEmptyString(): void
    {
        $decompressInputStream = $this->getDecompressInputStream('');
        $this->assertEquals('', $decompressInputStream->readBlock(3));
    }

    public function testReadBlock(): void
    {
        $decompressInputStream = $this->getDecompressInputStream(self::TEST_TEXT);
        $this->assertEquals(self::READ_BLOCK_TEXT, $decompressInputStream->readBlock(self::READ_BLOCK_LENGTH));
    }

    public function testReadBlockFully(): void
    {
        $this->assertEquals(self::TEST_TEXT, $this->decompressInputStream->readBlock(strlen(self::TEST_TEXT)));
    }

    public function testReadBlockWhenLengthGreaterThanStringLength(): void
    {
        $this->assertEquals(self::TEST_TEXT, $this->decompressInputStream->readBlock(strlen(self::TEST_TEXT) + 10));
    }

    public function testReadBlockReturnsStringOfRequiredLength(): void
    {
        $decompressInputStream = $this->getDecompressInputStream(self::TEST_TEXT);
        $this->assertEquals(1, strlen($decompressInputStream->readBlock(1)));
        $this->assertEquals(2, strlen($decompressInputStream->readBlock(2)));
        $this->assertEquals(4, strlen($decompressInputStream->readBlock(4)));
    }

    public function testReadBlockReturnsCorrectlyString(): void
    {
        $decompressInputStream = $this->getDecompressInputStream(self::TEST_TEXT);
        $this->assertEquals(substr(self::TEST_TEXT, 0, 3), $decompressInputStream->readBlock(3));
        $this->assertEquals(substr(self::TEST_TEXT, 3, 4), $decompressInputStream->readBlock(4));

    }

    public function testReturnsTrueIsEofWhenEmptyString(): void
    {
        $decompressInputStream = $this->getDecompressInputStream('');
        $this->assertTrue($decompressInputStream->isEof());
    }

    public function testReturnsTrueIsEofWhenEndHasBeenReached(): void
    {
        $decompressInputStream = $this->getDecompressInputStream(self::TEST_TEXT);
        $length = strlen(self::TEST_TEXT);
        for ($i = 0; $i < $length; $i++) {
            $this->assertFalse($decompressInputStream->isEof());
            $decompressInputStream->readByte();
        }
        $this->assertTrue($decompressInputStream->isEof());
    }

    protected function setUp(): void
    {
        $this->compressService = new CompressService();
        $this->compressed = $this->getCompressed(self::TEST_TEXT);
        $this->decompressInputStream = new DecompressInputStream(new InMemoryInputStream($this->compressed));
    }

    private function getDecompressInputStream(string $data): DecompressInputStream
    {
        $compressed = $this->getCompressed($data);
        return new DecompressInputStream(new InMemoryInputStream($compressed));
    }

    private function getCompressed(string $data): string
    {
        $compressed = '';
        $length = strlen($data);
        for ($i = 0; $i < $length; $i++) {
            $packed = $this->compressService->getPackedOrAccumulate($data[$i]);
            if (!$packed) {
                continue;
            }
            $compressed .= $packed;
        }
        return $compressed . $this->compressService->getPackedOrAccumulate('');
    }
}
