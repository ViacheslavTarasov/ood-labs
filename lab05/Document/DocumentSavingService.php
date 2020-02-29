<?php
declare(strict_types=1);

namespace Lab05\Document;

use Lab05\Service\FilesystemService;

class DocumentSavingService
{
    private const IMAGES_RELATIVE_DIR = 'images';

    /** @var HtmlGenerationService */
    private $htmlGenerationService;
    /** @var FilesystemService */
    private $filesystemService;

    public function __construct(HtmlGenerationService $htmlGenerationService, FilesystemService $filesystemService)
    {
        $this->htmlGenerationService = $htmlGenerationService;
        $this->filesystemService = $filesystemService;
    }

    public function saveAsHtml(string $path, string $title, DocumentItems $items): void
    {
        $dir = pathinfo($path, PATHINFO_DIRNAME);
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        if ($ext !== 'html') {
            throw new \InvalidArgumentException('invalid file extension');
        }
        if (!file_exists($dir)) {
            throw new \InvalidArgumentException('destination directory not exist');
        }
        if (file_exists($path)) {
            throw new \InvalidArgumentException('file exist');
        }
        $imagesAbsoluteDir = $dir . DIRECTORY_SEPARATOR . self::IMAGES_RELATIVE_DIR;
        $html = $this->htmlGenerationService->generate($title, $items, self::IMAGES_RELATIVE_DIR);
        file_put_contents($path, $html);
        $this->copyImages($items, $imagesAbsoluteDir);
    }

    private function copyImages(DocumentItems $items, string $destinationDir): void
    {
        $this->filesystemService->createDirectory($destinationDir);
        /** @var DocumentItem $item */
        foreach ($items as $item) {
            $image = $item->getImage();
            if ($image === null) {
                continue;
            }
            $destinationPath = $destinationDir . DIRECTORY_SEPARATOR . pathinfo($image->getPath(), PATHINFO_BASENAME);
            $this->filesystemService->copyFile($image->getPath(), $destinationPath);
        }
    }
}