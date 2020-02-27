<?php
declare(strict_types=1);

use Lab03\Stream\CompressOutputStream;
use Lab03\Stream\InMemoryOutputStream;
use PHPUnit\Framework\TestCase;

class CompressOutputStreamTest extends TestCase
{
    /** @var CompressOutputStream */
    private $compressOutputStream;
    /** @var InMemoryOutputStream */
    private $outputStream;

    public function testWriteByteDoesNotWriteInStreamWhenEmptyString(): void
    {
        $this->compressOutputStream->writeByte('');
        $this->compressOutputStream->writeByte('');
        $this->assertEquals(0, strlen($this->outputStream->getData()));
    }

    public function testWriteBlockDoesNotWriteInStreamWhenEmptyString(): void
    {
        $this->compressOutputStream->writeBlock('', 5);
        $this->assertEquals(0, strlen($this->outputStream->getData()));
    }

    public function testWriteByteDoesNotWriteInStreamIfNotChangedChar(): void
    {
        $this->compressOutputStream->writeByte('a');
        $this->compressOutputStream->writeByte('a');
        $this->compressOutputStream->writeByte('a');
        $this->assertEquals(0, strlen($this->outputStream->getData()));
    }

    public function testWriteByteWritesInStreamAfterChangedChar(): void
    {
        $char = 'a';
        $this->compressOutputStream->writeByte($char);
        $this->compressOutputStream->writeByte('');
        $this->assertEquals(2, strlen($this->outputStream->getData()));
        $this->assertEquals(1, $this->unpackCount(0));
        $this->assertEquals($char, $this->unpackChar(0));
    }

    private function unpackCount(int $number): int
    {
        return unpack('C', $this->outputStream->getData()[$number * 2])[1];
    }

    private function unpackChar(int $number): string
    {
        return unpack('a', $this->outputStream->getData()[$number * 2 + 1])[1];
    }

    public function testWriteByteCompressedSequenceOfIdenticalChars(): void
    {
        $length = 5;
        $char = 't';
        for ($i = 0; $i < $length; $i++) {
            $this->compressOutputStream->writeByte('t');
        }
        $this->compressOutputStream->writeByte('');
        $this->assertEquals($length, $this->unpackCount(0));
        $this->assertEquals($char, $this->unpackChar(0));
    }

    public function testBlockWasWrittenWhenDifferentCharacters(): void
    {
        $text = 'abcde';
        $this->compressOutputStream->writeBlock($text, 3);
        $this->compressOutputStream->writeBlock('', 1);

        $this->assertEquals(6, strlen($this->outputStream->getData()));

        $this->assertEquals(1, $this->unpackCount(0));
        $this->assertEquals($text[0], $this->unpackChar(0));

        $this->assertEquals(1, $this->unpackCount(1));
        $this->assertEquals($text[1], $this->unpackChar(1));

        $this->assertEquals(1, $this->unpackCount(2));
        $this->assertEquals($text[2], $this->unpackChar(2));
    }

    public function testBlockWasWrittenWhenLengthGreaterThanString(): void
    {
        $text = 'aabbb';
        $this->compressOutputStream->writeBlock($text, strlen($text) + 10);
        $this->compressOutputStream->writeBlock('', 1);

        $this->assertEquals(4, strlen($this->outputStream->getData()));

        $this->assertEquals(2, $this->unpackCount(0));
        $this->assertEquals('a', $this->unpackChar(0));

        $this->assertEquals(3, $this->unpackCount(1));
        $this->assertEquals('b', $this->unpackChar(1));
    }

    public function testWriteBlockCompressedString(): void
    {
        $text = 'aaaccxxxx';
        $this->compressOutputStream->writeBlock($text, strlen($text));
        $this->compressOutputStream->writeBlock('', 1);

        $this->assertEquals(6, strlen($this->outputStream->getData()));

        $this->assertEquals(3, $this->unpackCount(0));
        $this->assertEquals('a', $this->unpackChar(0));

        $this->assertEquals(2, $this->unpackCount(1));
        $this->assertEquals('c', $this->unpackChar(1));

        $this->assertEquals(4, $this->unpackCount(2));
        $this->assertEquals('x', $this->unpackChar(2));
    }

    protected function setUp(): void
    {
        $this->outputStream = new InMemoryOutputStream();
        $this->compressOutputStream = new CompressOutputStream($this->outputStream);
    }
}
