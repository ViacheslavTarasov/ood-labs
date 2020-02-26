<?php
declare(strict_types=1);

use Lab03\Stream\EncryptionMapGenerator;
use Lab03\Stream\EncryptionService;
use PHPUnit\Framework\TestCase;

class EncryptionServiceTest extends TestCase
{

    private const ENCRYPTION_KEY = 5;
    /** @var EncryptionService */
    private $encryption;
    private $map;

    public function testEncryptShouldEncodeEmptyStringIntoEmptyString(): void
    {
        $this->assertEquals('', $this->encryption->encrypt(''));
    }

    public function testEncryptShouldReturnsDifferentResultForDifferentChars(): void
    {
        $this->assertNotEquals($this->encryption->encrypt('a'), $this->encryption->encrypt('b'));
    }

    public function testEncryptShouldReturnsCharFromEncryptionMap(): void
    {
        $char = 'f';
        $expected = chr(array_search(ord($char), $this->map));
        $this->assertEquals($expected, $this->encryption->encrypt($char));
    }

    public function testDecryptShouldDecodeEmptyStringIntoEmptyString(): void
    {
        $this->assertEquals('', $this->encryption->encrypt(''));
    }

    public function testDecryptShouldReturnsCharFromEncryptionMap(): void
    {
        $char = 'N';
        $expected = chr($this->map[ord($char)]);
        $this->assertEquals($expected, $this->encryption->decrypt($char));
    }

    protected function setUp(): void
    {
        $this->map = (new EncryptionMapGenerator())->generate(self::ENCRYPTION_KEY);
        $this->encryption = new EncryptionService(self::ENCRYPTION_KEY);
    }
}
