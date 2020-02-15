<?php
declare(strict_types=1);

namespace Lab04\Helper {
    /**
     * @param int $count
     * @param array $data
     * @throws \InvalidArgumentException
     */
    function checkArraySize(int $count, array $data): void
    {
        if (count($data) !== $count) {
            throw new \InvalidArgumentException('invalid count arguments');
        }
    }
}

