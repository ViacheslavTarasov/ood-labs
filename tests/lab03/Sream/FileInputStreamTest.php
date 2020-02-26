<?php

use Lab03\Stream\FileInputStream;
use PHPUnit\Framework\TestCase;

class FileInputStreamTest extends TestCase
{
    private const TEST_TEXT = 'test text';
    private const FILE_PATH_INPUT = __DIR__ . '/test.input';
    /** @var FileInputStream */
    private $inputStream;

    public function testIsEofReturnsFalseWhenEndOfFileHasNotBeenReached(): void
    {
        $this->assertFalse($this->inputStream->isEof());
    }

    public function testIsEofReturnsTrueWhenEndOfFileHasBeenReached(): void
    {
        file_put_contents(self::FILE_PATH_INPUT, '');
        $inputStream = new FileInputStream(self::FILE_PATH_INPUT);
        $inputStream->readByte();
        $this->assertTrue($inputStream->isEof());
    }

    public function testReadBlockReturnsExpectedString(): void
    {
        $inputStream = new FileInputStream(self::FILE_PATH_INPUT);
        $this->assertEquals(self::TEST_TEXT, $inputStream->readBlock(strlen(self::TEST_TEXT)));
    }

    public function testReadByteReadsSequentiallyByOneChar(): void
    {
        $length = strlen(self::TEST_TEXT);
        $inputStream = new FileInputStream(self::FILE_PATH_INPUT);
        for ($i = 0; $i < $length; $i++) {
            $this->assertEquals(self::TEST_TEXT[$i], $inputStream->readByte());
        }
    }

    protected function setUp(): void
    {
        file_put_contents(self::FILE_PATH_INPUT, self::TEST_TEXT);
        $this->inputStream = new FileInputStream(self::FILE_PATH_INPUT);
    }

    protected function tearDown(): void
    {
        if (file_exists(self::FILE_PATH_INPUT)) {
            unlink(self::FILE_PATH_INPUT);
        }
    }
}
