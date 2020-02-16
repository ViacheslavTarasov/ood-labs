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

    public function setUp(): void
    {
        $this->map = (new EncryptionMapGenerator())->generate(self::ENCRYPTION_KEY);
        $this->encryption = new EncryptionService(self::ENCRYPTION_KEY);
    }

    public function testEncrypt(): void
    {
        $char = 'f';
        $expected = chr(array_search(ord($char), $this->map));
        $this->assertEquals('', $this->encryption->encrypt(''));
        $this->assertEquals($expected, $this->encryption->encrypt($char));
        $this->assertNotEquals($this->encryption->encrypt('a'), $this->encryption->encrypt('b'));
    }

    public function testDecrypt(): void
    {
        $char = 'N';
        $expected = chr($this->map[ord($char)]);
        $this->assertEquals('', $this->encryption->decrypt(''));
        $this->assertEquals($expected, $this->encryption->decrypt($char));
    }
}
