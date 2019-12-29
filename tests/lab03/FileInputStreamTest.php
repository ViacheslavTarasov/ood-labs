<?php


use Lab03\Stream\FileInputStream;
use PHPUnit\Framework\TestCase;

class FileInputStreamTest extends TestCase
{
    private const TEST_TEXT = 'test text';
    private const FILE_PATH_INPUT = __DIR__ . '/test.input';

    public function setUp(): void
    {
        file_put_contents(self::FILE_PATH_INPUT, self::TEST_TEXT);
    }

    public function tearDown(): void
    {
        if (file_exists(self::FILE_PATH_INPUT)) {
            unlink(self::FILE_PATH_INPUT);
        }
    }

    public function testIsEofIsFalse()
    {
        $inputStream = new FileInputStream(self::FILE_PATH_INPUT);
        $this->assertFalse($inputStream->isEof());
    }

    public function testIsEofIsTrue()
    {
        file_put_contents(self::FILE_PATH_INPUT, '');
        $inputStream = new FileInputStream(self::FILE_PATH_INPUT);
        $inputStream->readByte();
        $this->assertTrue($inputStream->isEof());
    }

    public function testReadBlock()
    {
        $inputStream = new FileInputStream(self::FILE_PATH_INPUT);
        $this->assertEquals(self::TEST_TEXT, $inputStream->readBlock(strlen(self::TEST_TEXT)));
    }

    public function testReadByte()
    {
        $inputStream = new FileInputStream(self::FILE_PATH_INPUT);
        for ($i = 0; $i < strlen(self::TEST_TEXT); $i++) {
            $this->assertEquals(self::TEST_TEXT[$i], $inputStream->readByte());
        }
    }
}
