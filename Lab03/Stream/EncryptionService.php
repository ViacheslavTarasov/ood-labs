<?php

namespace Lab03\Stream;

class EncryptionService
{
    private $map;
    private $transMap;

    public function __construct(int $key)
    {
        $this->map = (new EncryptionMapGenerator())->generate($key);
        $this->transMap = array_flip($this->map);
    }

    public function encrypt(string $byte): string
    {
        $encrypted = $byte;
        if ($byte !== '') {
            $ord = ord($byte);
            $encrypted = chr($this->transMap[$ord]);
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