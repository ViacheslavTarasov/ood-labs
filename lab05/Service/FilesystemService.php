<?php
declare(strict_types=1);

namespace Lab05\Service;

class FilesystemService
{
    public function copyFile(string $sourcePath, string $destinationPath): bool
    {
        if (!file_exists($sourcePath)) {
            throw new \InvalidArgumentException('invalid source path');
        }
        if (!file_exists(pathinfo($destinationPath, PATHINFO_DIRNAME))) {
            throw new \InvalidArgumentException('destination dir not exist');
        }
        return copy($sourcePath, $destinationPath);
    }

    public function delete(string $path): void
    {
        if (file_exists($path)) {
            unlink($path);
        }
    }

    public function fileExists(string $path): bool
    {
        return file_exists($path);
    }

    public function isImageFileType(string $path): bool
    {
        return @exif_imagetype($path) !== false;
    }


    public function createDirectory(string $directory): void
    {
        if (!is_dir($directory) && !mkdir($directory) && !is_dir($directory)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $directory));
        }
    }

}