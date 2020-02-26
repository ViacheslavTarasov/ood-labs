<?php
declare(strict_types=1);

use Lab03\Stream\DecryptInputStream;
use Lab03\Stream\EncryptionService;
use Lab03\Stream\InMemoryInputStream;
use Lab03\Stream\InputDataStreamInterface;
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

    public function testReadByteReturnsDecryptedByteFromEncryptedStream(): void
    {
        $this->assertEquals($this->encryptionService->decrypt(self::TEST_TEXT[0]), $this->decryptInputStream->readByte());
        $this->assertEquals($this->encryptionService->decrypt(self::TEST_TEXT[1]), $this->decryptInputStream->readByte());
    }

    public function testReadBlockReturnsDecryptedStringFromEncryptedStream(): void
    {
        $expected = '';
        $length = 3;
        for ($i = 0; $i < $length; $i++) {
            $expected .= $this->encryptionService->decrypt(self::TEST_TEXT[$i]);
        }
        $this->assertEquals($expected, $this->decryptInputStream->readBlock($length));
    }

    public function testIsEofReturnsTrueWhenInputStreamIsEofReturnsTrue(): void
    {
        $inputStream = $this->createMock(InputDataStreamInterface::class);
        $inputStream->expects($this->once())->method('isEof')->willReturn(true);
        $decryptInputStream = new DecryptInputStream($inputStream, self::ENCRYPTION_KEY);
        $this->assertTrue($decryptInputStream->isEof());
    }

    public function testIsEofReturnsFalseWhenInputStreamIsEofReturnsFalse(): void
    {
        $inputStream = $this->createMock(InputDataStreamInterface::class);
        $inputStream->expects($this->once())->method('isEof')->willReturn(false);
        $decryptInputStream = new DecryptInputStream($inputStream, self::ENCRYPTION_KEY);
        $this->assertFalse($decryptInputStream->isEof());
    }

    public function testIsEofReturnsTrueWhenEndOfStreamHasBeenReached(): void
    {
        $length = strlen(self::TEST_TEXT);
        for ($i = 0; $i < $length; $i++) {
            $this->assertFalse($this->decryptInputStream->isEof());
            $this->decryptInputStream->readByte();
        }
        $this->assertTrue($this->decryptInputStream->isEof());
    }

    protected function setUp(): void
    {
        $this->inputStream = new InMemoryInputStream(self::TEST_TEXT);
        $this->decryptInputStream = new DecryptInputStream($this->inputStream, self::ENCRYPTION_KEY);
        $this->encryptionService = new EncryptionService(self::ENCRYPTION_KEY);
    }
}
