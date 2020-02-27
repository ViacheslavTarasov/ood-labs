<?php
declare(strict_types=1);

namespace Lab05\Service;

use Lab05\Service\Input\DocumentItemsInput;
use Lab05\Service\Input\ImageInput;
use Lab05\Service\Input\ParagraphInput;

class HtmlGenerationService
{
    public function generate(string $title, DocumentItemsInput $items, string $imagesRelativeDir): string
    {
        $body = '';
        $title = htmlspecialchars($title);
        foreach ($items as $item) {
            if ($item instanceof ImageInput) {
                $src = $this->getImageRelativePath($item, $imagesRelativeDir);
                $body .= "<img src='{$src}' width='{$item->getWidth()}' height='{$item->getHeight()}' alt=''>";
            }
            if ($item instanceof ParagraphInput) {
                $text = htmlspecialchars($item->getText());
                $body .= "<p>{$text}</p>";
            }
        }
        return $this->getHtml($title, $body);
    }

    private function getImageRelativePath(ImageInput $image, string $imagesRelativeDir): string
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