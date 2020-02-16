<?php
declare(strict_types=1);

namespace Lab03\Stream;

class EncryptionMapGenerator
{
    public function generate(int $key): array
    {
        mt_srand($key);
        $map = [];
        for ($i = 0; $i <= 255; $i++) {
            do {
                $value = mt_rand(0, 255);
            } while (in_array($value, $map));
            $map[] = $value;
        }
        return $map;
    }
}