<?php

use Lab03\Stream\FileOutputStream;
use PHPUnit\Framework\TestCase;

class FileOutputStreamTest extends TestCase
{
    private const TEST_TEXT = 'test text';
    private const FILE_PATH_OUTPUT = __DIR__ . '/test.output';

    public function setUp(): void
    {
        file_put_contents(self::FILE_PATH_OUTPUT, '');
    }

    public function tearDown(): void
    {
        if (file_exists(self::FILE_PATH_OUTPUT)) {
            unlink(self::FILE_PATH_OUTPUT);
        }
    }

    public function testWriteByteEmpty(): void
    {
        $outputStream = new FileOutputStream(self::FILE_PATH_OUTPUT);
        $outputStream->writeByte('');
        $this->assertEquals(file_get_contents(self::FILE_PATH_OUTPUT), '');
    }

    public function testWriteByte(): void
    {
        $length = strlen(self::TEST_TEXT);
        $outputStream = new FileOutputStream(self::FILE_PATH_OUTPUT);
        for ($i = 0; $i < $length; $i++) {
            $outputStream->writeByte(self::TEST_TEXT[$i]);
            $this->assertEquals(file_get_contents(self::FILE_PATH_OUTPUT), substr(self::TEST_TEXT, 0, $i + 1));
        }
    }

    public function testWriteBlockEmpty(): void
    {
        $outputStream = new FileOutputStream(self::FILE_PATH_OUTPUT);
        $outputStream->writeBlock('', 10);
        $this->assertEquals(file_get_contents(self::FILE_PATH_OUTPUT), '');
    }

    public function testWriteBlock(): void
    {
        $outputStream = new FileOutputStream(self::FILE_PATH_OUTPUT);
        $outputStream->writeBlock(self::TEST_TEXT, strlen(self::TEST_TEXT));
        $this->assertEquals(file_get_contents(self::FILE_PATH_OUTPUT), self::TEST_TEXT);
    }


    public function testWriteBlockPart(): void
    {
        $length = 4;
        $outputStream = new FileOutputStream(self::FILE_PATH_OUTPUT);
        $outputStream->writeBlock(self::TEST_TEXT, $length);
        $this->assertEquals(file_get_contents(self::FILE_PATH_OUTPUT), substr(self::TEST_TEXT, 0, $length));
    }
}
