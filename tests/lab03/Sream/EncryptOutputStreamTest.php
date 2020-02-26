<?php

use Lab03\Stream\EncryptionService;
use Lab03\Stream\EncryptOutputStream;
use Lab03\Stream\InMemoryOutputStream;
use PHPUnit\Framework\TestCase;

class EncryptOutputStreamTest extends TestCase
{
    private const TEST_TEXT = 'test text';
    private const ENCRYPTION_KEY = 5;
    /** @var EncryptOutputStream */
    private $encryptOutputStream;
    /** @var InMemoryOutputStream */
    private $outputStream;
    /** @var EncryptionService */
    private $encryptionService;

    public function testWriteByteWrittenEmptyString(): void
    {
        $this->encryptOutputStream->writeByte('');
        $this->assertEquals('', $this->outputStream->getData());
    }

    public function testWriteByteWrittenEncryptedByteInStream(): void
    {
        $char = 'a';
        $this->encryptOutputStream->writeByte($char);
        $this->assertEquals($this->encryptionService->encrypt($char), $this->outputStream->getData());
        $this->assertEquals(1, strlen($this->outputStream->getData()));
    }

    public function testWriteBlockWrittenEncryptedBlockInStream(): void
    {
        $expected = '';
        $length = 5;
        for ($i = 0; $i < $length; $i++) {
            $expected .= $this->encryptionService->encrypt(self::TEST_TEXT[$i]);
        }
        $this->encryptOutputStream->writeBlock(self::TEST_TEXT, $length);
        $this->assertEquals($expected, $this->outputStream->getData());
    }

    protected function setUp(): void
    {
        $this->outputStream = new InMemoryOutputStream();
        $this->encryptOutputStream = new EncryptOutputStream($this->outputStream, self::ENCRYPTION_KEY);
        $this->encryptionService = new EncryptionService(self::ENCRYPTION_KEY);
    }
}
