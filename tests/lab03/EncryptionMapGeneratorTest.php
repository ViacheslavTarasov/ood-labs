<?php


use Lab03\Stream\EncryptionMapGenerator;
use PHPUnit\Framework\TestCase;

class EncryptionMapGeneratorTest extends TestCase
{

    public function testGenerate()
    {
        $encryptionMap1 = (new EncryptionMapGenerator())->generate(3);
        $encryptionMap2 = (new EncryptionMapGenerator())->generate(3);
        $this->assertEquals($encryptionMap1, $encryptionMap2);
    }
}
