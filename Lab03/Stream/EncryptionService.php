<?php

namespace Lab03\Stream;

class EncryptionService
{
    private $map;

    public function __construct(int $key)
    {
        $this->map = $this->map = (new EncryptionMapGenerator())->generate($key);
    }

    public function encrypt(string $byte): string
    {
        $encrypted = $byte;
        if ($byte !== '') {
            $ord = ord($byte);
            $index = array_search($ord, $this->map);
            $encrypted = chr($index);
        }
        return $encrypted;
    }

    public function decrypt(string $byte): string
    {
        $decrypted = $byte;
        if ($byte !== '') {
            $ord = ord($byte);
            $decrypted = chr($this->map[$ord]);
        }
        return $decrypted;
    }
}