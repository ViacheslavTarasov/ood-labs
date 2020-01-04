<?php

use Lab03\Stream\DecompressInputStream;
use Lab03\Stream\InMemoryInputStream;
use PHPUnit\Framework\TestCase;

class DecompressInputStreamTest extends TestCase
{
    private const TEST_TEXT = 'teeeeeest';
    /** @var DecompressInputStream */
    private $decompressInputStream;
    private $inputStream;
    private $compressed;

    public function setUp(): void
    {
        $this->compressed = pack('CaCaCaCa', 1, 't', 6, 'e', 1, 's', 1, 't');
        $this->inputStream = new InMemoryInputStream($this->compressed);
        $this->decompressInputStream = new DecompressInputStream($this->inputStream);
    }

    public function testDecompress(): void
    {
        $result = '';
        while (!$this->decompressInputStream->isEof()) {
            $result .= $this->decompressInputStream->readByte();
        }
        $this->assertEquals(self::TEST_TEXT, $result);
    }

    public function testIsEof(): void
    {
        $i = 0;
        while (!$this->decompressInputStream->isEof()) {
            $this->decompressInputStream->readByte();
            $i++;
        }
        $this->assertEquals(strlen($this->compressed) / 2, $i);
    }

    public function testReadByte(): void
    {
        $this->assertEquals('t', $this->decompressInputStream->readByte());
        $this->assertEquals('eeeeee', $this->decompressInputStream->readByte());
    }

    public function testReadBlock(): void
    {
        $this->assertEquals('teeeeee', $this->decompressInputStream->readBlock(2));
    }

    public function testReadBlockPartially(): void
    {
        $this->assertEquals('teeeeees', $this->decompressInputStream->readBlock(3));
    }

    public function testReadBlockFully(): void
    {
        $this->assertEquals(self::TEST_TEXT, $this->decompressInputStream->readBlock(strlen(self::TEST_TEXT)));
    }
}
