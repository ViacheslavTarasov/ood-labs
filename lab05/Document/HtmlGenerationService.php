<?php
declare(strict_types=1);

namespace Lab05\Document;

class HtmlGenerationService
{
    public function generate(string $title, DocumentItems $items, string $imagesRelativeDir): string
    {
        $body = '';
        $title = htmlspecialchars($title);
        /** @var DocumentItem $item */
        foreach ($items as $item) {
            $image = $item->getImage();
            if ($image) {
                $src = $this->getImageRelativePath($image, $imagesRelativeDir);
                $body .= "<img src='{$src}' width='{$image->getWidth()}' height='{$image->getHeight()}' alt=''>";
            }
            $paragraph = $item->getParagraph();
            if ($paragraph) {
                $text = htmlspecialchars($paragraph->getText());
                $body .= "<p>{$text}</p>";
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
            <html lang=\"en\">
                <head>
                    <title>{$title}</title>
                </head>
                <body>
                    {$body}
                </body>
            </html>";
    }
}