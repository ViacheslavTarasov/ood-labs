<?php
declare(strict_types=1);

namespace Lab05\Command\Document;

abstract class AbstractCommand implements CommandInterface
{
    private $executed = false;

    public function execute(): void
    {
        if (!$this->executed) {
            $this->doExecute();
            $this->executed = true;
        }
    }

    public function unexecute(): void
    {
        if ($this->executed) {
            $this->doUnexecute();
            $this->executed = false;
        }
    }

    public function isExecuted(): bool
    {
        return $this->executed;
    }

    abstract protected function doExecute(): void;

    abstract protected function doUnexecute(): void;

}