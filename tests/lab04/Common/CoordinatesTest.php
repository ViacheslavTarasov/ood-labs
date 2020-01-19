<?php


use Lab04\Common\Coordinates;
use PHPUnit\Framework\TestCase;

class CoordinatesTest extends TestCase
{
    private const X_VALUE = 100;
    private const Y_VALUE = 100;
    /** @var Coordinates */
    private $coordinates;

    public function setUp(): void
    {
        $this->coordinates = new Coordinates(self::X_VALUE, self::Y_VALUE);
    }

    public function testGetters()
    {
        $this->assertEquals(self::X_VALUE, $this->coordinates->getX());
        $this->assertEquals(self::Y_VALUE, $this->coordinates->getY());
    }
}
