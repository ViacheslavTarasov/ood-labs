<?php

namespace Tests\Lab02;

use Lab02\Common\PriorityStorage;
use PHPUnit\Framework\TestCase;

class PriorityStorageTest extends TestCase
{
    public function testPriority(): void
    {
        $a = new class
        {
        };
        $b = new class
        {
        };
        $c = new class
        {
        };
        $storage = new PriorityStorage();
        $storage->attach($a, 2);
        $storage->attach($c, 1);
        $storage->attach($b, 3);
        $storage->attach($b, 4);
        $storage->attach($a, 10);

        $expected = [get_class($b), get_class($a), get_class($c)];
        $actual = [];
        foreach ($storage as $value) {
            $actual[] = get_class($value);
        }

        $this->assertEquals($expected, $actual);
    }
}
