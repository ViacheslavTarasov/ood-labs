<?php
declare(strict_types=1);

use Lab05\Document\Image;
use Lab05\Document\ImageInterface;
use PHPUnit\Framework\TestCase;

class ImageTest extends TestCase
{
    private const SRC_PATH = '../test.png';
    private const WIDTH = 600;
    private const HEIGHT = 400;
    /** @var ImageInterface */
    private $image;

    public function testGettersReturn(): void
    {
        $this->assertEquals(self::SRC_PATH, $this->image->getPath());
        $this->assertEquals(self::WIDTH, $this->image->getWidth());
        $this->assertEquals(self::HEIGHT, $this->image->getHeight());
    }

    /**
     * @dataProvider validSizeDataProvide
     * @param int $width
     * @param int $height
     */
    public function testCreateImageWithValidParams(int $width, int $height): void
    {
        new Image(self::SRC_PATH, $width, $height);
        $this->assertTrue(true);
    }

    public function testThrowsExceptionWhenCreateWithInvalidWidth(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Image(self::SRC_PATH, Image::MIN_SIZE - 1, self::HEIGHT);
        $this->expectException(InvalidArgumentException::class);
        new Image(self::SRC_PATH, Image::MAX_SIZE + 1, self::HEIGHT);
    }

    public function testThrowsExceptionWhenCreateWithInvalidHeight(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Image(self::SRC_PATH, self::WIDTH, Image::MIN_SIZE - 1);
        $this->expectException(InvalidArgumentException::class);
        new Image(self::SRC_PATH, self::WIDTH, Image::MAX_SIZE + 1);
    }

    /**
     * @dataProvider validSizeDataProvide
     * @param int $width
     * @param int $heigh
     */
    public function testResizeImageWhenValidParams(int $width, int $heigh): void
    {
        $this->image->resize($width, $heigh);
        $this->assertTrue(true);
    }

    public function testThrowsExceptionWhenResizeWithInvalidWidth(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->image->resize(Image::MIN_SIZE - 1, Image::MIN_SIZE);
        $this->expectException(InvalidArgumentException::class);
        $this->image->resize(Image::MAX_SIZE + 1, Image::MIN_SIZE);
    }

    public function testThrowsExceptionWhenResizeWithInvalidHeight(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->image->resize(Image::MIN_SIZE, Image::MIN_SIZE - 1);
        $this->expectException(InvalidArgumentException::class);
        $this->image->resize(Image::MIN_SIZE, Image::MAX_SIZE + 1);
    }

    public function validSizeDataProvide(): array
    {
        return [
            [Image::MIN_SIZE, Image::MIN_SIZE],
            [Image::MIN_SIZE + 1, Image::MIN_SIZE + 1],
            [Image::MIN_SIZE, Image::MAX_SIZE],
            [Image::MIN_SIZE + 1, Image::MAX_SIZE - 1],
            [Image::MAX_SIZE, Image::MAX_SIZE],
            [Image::MAX_SIZE - 1, Image::MAX_SIZE - 1],
            [Image::MAX_SIZE, Image::MIN_SIZE],
            [Image::MAX_SIZE - 1, Image::MIN_SIZE + 1],
        ];
    }

    protected function setUp(): void
    {
        $this->image = new Image(self::SRC_PATH, self::WIDTH, self::HEIGHT);
    }
}