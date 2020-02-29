<?php
declare(strict_types=1);

use Lab05\Document\ImageManager;
use Lab05\Service\FilesystemService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ImageManagerTest extends TestCase
{
    private const SRC_PATH = 'src.png';
    private const IMAGES_PATH = 'document/images';
    /** @var ImageManager */
    private $imageManager;
    /** @var FilesystemService|MockObject */
    private $filesystemService;

    public function testSaveCallsCopyFileWithParams(): void
    {
        $this->filesystemService->method('fileExists')->willReturn(true);
        $this->filesystemService->method('isImageFileType')->willReturn(true);
        $this->filesystemService->expects($this->once())->method('copyFile')->with(
            $this->equalTo(self::SRC_PATH),
            $this->stringContains(self::IMAGES_PATH)
        );
        $this->imageManager->save(self::SRC_PATH, self::IMAGES_PATH);
    }

    protected function setUp(): void
    {
        $this->filesystemService = $this->createMock(FilesystemService::class);
        $this->imageManager = new ImageManager($this->filesystemService);
    }
}
