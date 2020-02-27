<?php
declare(strict_types=1);

namespace Lab05\Service\Input;

class ParagraphInput
{
    /** @var string */
    private $text;

    public function __construct(string $text)
    {
        $this->text = $text;
    }

    public function getText(): string
    {
        return $this->text;
    }
}