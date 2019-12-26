<?php


use Lab03\Stream\FileInputStream;
use PHPUnit\Framework\TestCase;

class FileInputStreamTest extends TestCase
{
    private const FILE_PATH_INPUT = __DIR__ . '/test.input';
    private const FILE_PATH_OUTPUT = __DIR__ . '/test.output';

    public function setUp(): void
    {
        file_put_contents(self::FILE_PATH_INPUT, 'test');
        $f = fopen(self::FILE_PATH_OUTPUT, 'w');
        fclose($f);
    }

    public function testIsEof()
    {
        $inputStream = new FileInputStream();
        $text = 'test';
        file_put_contents(self::FILE_PATH_INPUT, $text);
        $file = fopen(self::FILE_PATH_INPUT, 'rb');
        $this->assertFalse($inputStream->isEof($file));
        fclose($file);

        $text = '';
        file_put_contents(self::FILE_PATH_INPUT, $text);
        $file = fopen(self::FILE_PATH_INPUT, 'rb');
        fread($file, 1);
        $this->assertTrue($inputStream->isEof($file));
        fclose($file);
    }

    public function testReadBlock()
    {
        $text = 'test';
        file_put_contents(self::FILE_PATH_INPUT, $text);
        $file = fopen(self::FILE_PATH_INPUT, 'rb');
        $inputStream = new FileInputStream();
        $this->assertEquals($text, $inputStream->readBlock($file, strlen($text)));
        fclose($file);
    }

    public function testReadByte()
    {
        $text = 'test';
        file_put_contents(self::FILE_PATH_INPUT, $text);
        $file = fopen(self::FILE_PATH_INPUT, 'rb');
        $inputStream = new FileInputStream();
        for ($i = 0; $i < strlen($text); $i++) {
            $this->assertEquals($text[$i], $inputStream->readByte($file));
        }
        fclose($file);
    }
}
