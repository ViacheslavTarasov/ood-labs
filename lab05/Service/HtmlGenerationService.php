<?php
declare(strict_types=1);

namespace Lab05\Service;

use Lab05\Document\DocumentItemInterface;
use Lab05\Document\DocumentItems;
use Lab05\Document\ImageInterface;

class HtmlGenerationService
{
    public function generate(string $title, DocumentItems $items, string $imagesRelativeDir): string
    {
        $body = '';
        /** @var DocumentItemInterface $item */
        foreach ($items as $item) {
            $image = $item->getImage();
            if ($image) {
                $src = $this->getImageRelativePath($image, $imagesRelativeDir);
                $body .= "<img src='{$src}' width='{$image->getWidth()}' height='{$image->getHeight()}' alt=''>";
            }
            $paragraph = $item->getParagraph();
            if ($paragraph) {
                $body .= "<p>{$paragraph->getText()}</p>";
            }
        }
        return $this->getHtml($title, $body);
    }

    private function getImageRelativePath(ImageInterface $image, string $imagesRelativeDir): string
    {
        return $imagesRelativeDir . DIRECTORY_SEPARATOR . pathinfo($image->getPath(), PATHINFO_BASENAME);
    }

    private function getHtml(string $title, string $body): string
    {
        return "
            <!DOCTYPE html>
            <html>
                <head>
                    <title>{$title}</title>
                </head>
                <body>
                    {$body}
                </body>
            </html>";
    }
}