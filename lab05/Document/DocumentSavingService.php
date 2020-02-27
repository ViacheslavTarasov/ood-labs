<?php
declare(strict_types=1);

namespace Lab05\Document;

use Lab05\Service\FilesystemService;
use Lab05\Service\HtmlGenerationService;
use Lab05\Service\Input\DocumentItemsInput;
use Lab05\Service\Input\ImageInput;
use Lab05\Service\Input\ParagraphInput;

class DocumentSavingService
{
    private const IMAGES_RELATIVE_DIR = 'images';
    /** @var HtmlGenerationService */
    private $htmlGenerationService;
    /** @var FilesystemService */
    private $filesystemService;

    /**
     * DocumentSavingService constructor.
     * @param HtmlGenerationService $htmlGenerationService
     * @param FilesystemService $filesystemService
     */
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
        $inputItems = [];
        /** @var DocumentItem $item */
        foreach ($items as $item) {
            if ($item->getParagraph()) {
                $inputItems[] = new ParagraphInput($item->getParagraph()->getText());
            }
            $image = $item->getImage();
            if ($image) {
                $inputItems[] = new ImageInput($image->getPath(), $image->getWidth(), $image->getHeight());
            }

        }
        $documentsItemsInput = new DocumentItemsInput($inputItems);
        file_put_contents($path, $this->htmlGenerationService->generate($title, $documentsItemsInput, self::IMAGES_RELATIVE_DIR));
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