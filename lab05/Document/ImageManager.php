<?php
declare(strict_types=1);

namespace Lab05\Document;

use InvalidArgumentException;
use Lab05\Service\FilesystemService;

class ImageManager
{
    /** @var FilesystemService */
    private $filesystemService;

    public function __construct(FilesystemService $filesystemService)
    {
        $this->filesystemService = $filesystemService;
    }

    public function save(string $originalPath, string $destinationDir): string
    {
        if (!$this->filesystemService->fileExists($originalPath)) {
            throw new InvalidArgumentException('file not exist');
        }

        if (!$this->filesystemService->isImageFileType($originalPath)) {
            throw new InvalidArgumentException('file is not an image');
        }

        $ext = pathinfo($originalPath, PATHINFO_EXTENSION);
        $newPath = rtrim($destinationDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . uniqid('img', true) . '.' . $ext;

        $this->filesystemService->copyFile($originalPath, $newPath);
        return $newPath;
    }

    public function delete(string $path): void
    {
        $this->filesystemService->delete($path);
    }
}