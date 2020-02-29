<?php
declare(strict_types=1);

use Lab05\Document\Image;
use Lab05\Document\ImageInterface;
use Lab05\History\History;
use PHPUnit\Framework\TestCase;

class ImageTest extends TestCase
{
    private const SRC_PATH = '../test.png';
    private const WIDTH = 600;
    private const HEIGHT = 400;

    /** @var History */
    private $history;
    /** @var ImageInterface */
    private $image;

    public function testGettersReturnCorrectlyValues(): void
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
        new Image($this->history, self::SRC_PATH, $width, $height);
        $this->assertTrue(true);
    }

    public function testCreateImageThrowsExceptionWhenWidthLessThanMinWidth(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Image($this->history, self::SRC_PATH, Image::MIN_SIZE - 1, self::HEIGHT);
    }

    public function testCreateImageThrowsExceptionWhenWidthMoreThanMaxWidth(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Image($this->history, self::SRC_PATH, Image::MAX_SIZE + 1, self::HEIGHT);
    }

    public function testCreateImageThrowsExceptionWhenHeightLessThanMinWidth(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Image($this->history, self::SRC_PATH, Image::MIN_SIZE, Image::MIN_SIZE - 1);
    }

    public function testCreateImageThrowsExceptionWhenHeightMoreThanMaxWidth(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Image($this->history, self::SRC_PATH, Image::MIN_SIZE, Image::MAX_SIZE + 1);
    }

    /**
     * @dataProvider validSizeDataProvide
     * @param int $width
     * @param int $height
     */
    public function testResizeShouldChangeImageSizeWhenValidParams(int $width, int $height): void
    {
        $this->image->resize($width, $height);
        $this->assertEquals($width, $this->image->getWidth());
        $this->assertEquals($height, $this->image->getHeight());
    }

    public function testResizeThrowsExceptionWhenWidthLessThanMinWidth(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->image->resize(Image::MIN_SIZE - 1, Image::MIN_SIZE);
    }

    public function testResizeThrowsExceptionWhenWidthMoreThanMaxWidth(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->image->resize(Image::MAX_SIZE + 1, Image::MIN_SIZE);
    }

    public function testResizeThrowsExceptionWhenHeightLessThanMinWidth(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->image->resize(Image::MIN_SIZE, Image::MIN_SIZE - 1);
    }

    public function testResizeThrowsExceptionWhenHeightMoreThanMaxWidth(): void
    {
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
        $this->history = new Lab05\History\History(10);
        $this->image = new Image($this->history, self::SRC_PATH, self::WIDTH, self::HEIGHT);
    }
}