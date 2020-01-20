<?php


use Lab04\Common\Point;
use PHPUnit\Framework\TestCase;

class PointTest extends TestCase
{
    private const X_VALUE = 100;
    private const Y_VALUE = 100;
    /** @var Point */
    private $coordinates;

    public function setUp(): void
    {
        $this->coordinates = new Point(self::X_VALUE, self::Y_VALUE);
    }

    public function testGetters()
    {
        $this->assertEquals(self::X_VALUE, $this->coordinates->getX());
        $this->assertEquals(self::Y_VALUE, $this->coordinates->getY());
    }
}
