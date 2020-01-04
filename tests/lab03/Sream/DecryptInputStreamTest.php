<?php

use Lab03\Stream\DecryptInputStream;
use Lab03\Stream\EncryptionService;
use Lab03\Stream\InMemoryInputStream;
use PHPUnit\Framework\TestCase;

class DecryptInputStreamTest extends TestCase
{
    private const TEST_TEXT = 'test text';
    private const ENCRYPTION_KEY = 5;
    /** @var DecryptInputStream */
    private $decryptInputStream;
    private $inputStream;
    /** @var EncryptionService */
    private $encryptionService;

    public function setUp(): void
    {
        $this->inputStream = new InMemoryInputStream(self::TEST_TEXT);
        $this->decryptInputStream = new DecryptInputStream($this->inputStream, self::ENCRYPTION_KEY);
        $this->encryptionService = new EncryptionService(self::ENCRYPTION_KEY);
    }

    public function testReadByte(): void
    {
        $this->assertEquals($this->encryptionService->decrypt(self::TEST_TEXT[0]), $this->decryptInputStream->readByte());
        $this->assertEquals($this->encryptionService->decrypt(self::TEST_TEXT[1]), $this->decryptInputStream->readByte());
    }

    public function testReadBlock(): void
    {
        $expected = '';
        $length = intval(strlen(self::TEST_TEXT) / 2);
        for ($i = 0; $i < $length; $i++) {
            $expected .= $this->encryptionService->decrypt(self::TEST_TEXT[$i]);
        }
        $this->assertEquals($expected, $this->decryptInputStream->readBlock($length));
    }

    public function testIsEof(): void
    {
        $i = 0;
        while (!$this->decryptInputStream->isEof()) {
            $this->decryptInputStream->readByte();
            $i++;
        }
        $this->assertEquals(strlen(self::TEST_TEXT), $i);
    }
}
