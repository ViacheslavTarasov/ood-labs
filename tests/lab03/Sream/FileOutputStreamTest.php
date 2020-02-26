<?php

use Lab03\Stream\FileOutputStream;
use PHPUnit\Framework\TestCase;

class FileOutputStreamTest extends TestCase
{
    private const TEST_TEXT = 'test text';
    private const FILE_PATH_OUTPUT = __DIR__ . '/test.output';

    /** @var FileOutputStream */
    private $outputStream;

    public function testWriteByteEmptyStringNothingWritingInFile(): void
    {
        $this->outputStream->writeByte('');
        $this->assertEquals(file_get_contents(self::FILE_PATH_OUTPUT), '');
    }

    public function testWriteByteWritingCharsInFileSequentially(): void
    {
        $length = strlen(self::TEST_TEXT);
        for ($i = 0; $i < $length; $i++) {
            $this->outputStream->writeByte(self::TEST_TEXT[$i]);
            $this->assertEquals(file_get_contents(self::FILE_PATH_OUTPUT), substr(self::TEST_TEXT, 0, $i + 1));
        }
    }

    public function testWriteBlockWritingEmptyStringInFile(): void
    {
        $this->outputStream->writeBlock('', 10);
        $this->assertEquals(file_get_contents(self::FILE_PATH_OUTPUT), '');
    }

    public function testWriteBlockWritingExpectedTextInFile(): void
    {
        $this->outputStream->writeBlock(self::TEST_TEXT, strlen(self::TEST_TEXT));
        $this->assertEquals(file_get_contents(self::FILE_PATH_OUTPUT), self::TEST_TEXT);
    }

    protected function setUp(): void
    {
        file_put_contents(self::FILE_PATH_OUTPUT, '');
        $this->outputStream = new FileOutputStream(self::FILE_PATH_OUTPUT);
    }

    protected function tearDown(): void
    {
        if (file_exists(self::FILE_PATH_OUTPUT)) {
            unlink(self::FILE_PATH_OUTPUT);
        }
    }
}
