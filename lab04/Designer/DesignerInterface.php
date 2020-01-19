<?php
declare(strict_types=1);

namespace Lab04\Designer;

use Lab04\PictureDraft\PictureDraft;

interface DesignerInterface
{
    public function createDraft(\SplFileObject $stdin): PictureDraft;
}