<?php


use Lab03\Stream\CompressOutputStream;
use Lab03\Stream\InMemoryOutputStream;
use PHPUnit\Framework\TestCase;

class CompressOutputStreamTest extends TestCase
{
    private const TEST_TEXT = 'teeeeee';
    /** @var CompressOutputStream */
    private $compressOutputStream;
    /** @var InMemoryOutputStream */
    private $outputStream;

    public function setUp(): void
    {
        $this->outputStream = new InMemoryOutputStream();
        $this->compressOutputStream = new CompressOutputStream($this->outputStream);
    }

    public function testWriteByte(): void
    {
        $this->compressOutputStream->writeByte(self::TEST_TEXT[0]);
        $this->compressOutputStream->writeByte('');
        $this->assertEquals(2, strlen($this->outputStream->getData()));
        $this->assertEquals('1', unpack('C', $this->outputStream->getData()[0])[1]);
        $this->assertEquals(self::TEST_TEXT[0], unpack('a', $this->outputStream->getData()[1])[1]);
    }

    public function testWriteBlock(): void
    {
        $this->compressOutputStream->writeBlock(self::TEST_TEXT, 2);
        $this->compressOutputStream->writeBlock('', 1);
        $this->assertEquals(4, strlen($this->outputStream->getData()));
        $this->assertEquals('1', unpack('C', $this->outputStream->getData()[0])[1]);
        $this->assertEquals(self::TEST_TEXT[0], unpack('a', $this->outputStream->getData()[1])[1]);
        $this->assertEquals('1', unpack('C', $this->outputStream->getData()[2])[1]);
        $this->assertEquals(self::TEST_TEXT[1], unpack('a', $this->outputStream->getData()[3])[1]);
    }

    public function testCompress(): void
    {
        for ($i = 0; $i < strlen(self::TEST_TEXT); $i++) {
            $this->compressOutputStream->writeByte(self::TEST_TEXT[$i]);
        }
        $this->compressOutputStream->writeByte('');

        $this->assertEquals(4, strlen($this->outputStream->getData()));
        $this->assertEquals('1', unpack('C', $this->outputStream->getData()[0])[1]);
        $this->assertEquals(self::TEST_TEXT[0], unpack('a', $this->outputStream->getData()[1])[1]);
        $this->assertEquals('6', unpack('C', $this->outputStream->getData()[2])[1]);
        $this->assertEquals(self::TEST_TEXT[1], unpack('a', $this->outputStream->getData()[3])[1]);
    }
}
