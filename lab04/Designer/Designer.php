<?php
declare(strict_types=1);

namespace Lab04\Designer;

use Lab04\PictureDraft\PictureDraft;
use Lab04\Shape\ShapeFactoryInterface;

class Designer
{
    /** @var ShapeFactoryInterface */
    private $shapeFactory;

    public function __construct(ShapeFactoryInterface $shapeFactory)
    {
        $this->shapeFactory = $shapeFactory;
    }

    public function createDraft(\SplFileObject $stdin): PictureDraft
    {
        $draft = new PictureDraft();
        do {
            echo 'Command: ';
            $line = trim($stdin->fgets());
            if (!$line) {
                continue;
            }
            if (strtolower($line) === 'done') {
                break;
            }
            $shape = $this->shapeFactory->createShape($line);
            $draft->addShape($shape);
        } while (true);
        return $draft;
    }
}