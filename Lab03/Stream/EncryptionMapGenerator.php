<?php

namespace Lab03\Stream;

class EncryptionMapGenerator
{
    public function generate(int $key)
    {
        mt_srand($key);
        $map = [];
        for ($i = 0; $i <= 255; $i++) {
            do {
                $value = mt_rand(0, 255);
            } while (in_array($value, $map));
            array_push($map, $value);
        }
        return $map;
    }
}