<?php
declare(strict_types=1);

use Lab03\Stream\EncryptionMapGenerator;
use PHPUnit\Framework\TestCase;

class EncryptionMapGeneratorTest extends TestCase
{

    public function testGeneratedMapSizeOf256(): void
    {
        $encryptionMap = (new EncryptionMapGenerator())->generate(3);
        $this->assertEquals(256, count($encryptionMap));
    }

    public function testGeneratedMapWithUniqValues(): void
    {
        $encryptionMap = (new EncryptionMapGenerator())->generate(3);
        $this->assertEquals(count($encryptionMap), count(array_unique($encryptionMap)));
    }

    public function testGeneratedDifferentMapsForDifferentKeys(): void
    {
        $encryptionMap1 = (new EncryptionMapGenerator())->generate(3);
        $encryptionMap2 = (new EncryptionMapGenerator())->generate(5);
        $this->assertNotEquals($encryptionMap1, $encryptionMap2);
    }

    public function testGeneratedIdentityMapsForIdentityKeys(): void
    {
        $encryptionMap1 = (new EncryptionMapGenerator())->generate(3);
        $encryptionMap2 = (new EncryptionMapGenerator())->generate(3);
        $this->assertEquals($encryptionMap1, $encryptionMap2);
    }
}
