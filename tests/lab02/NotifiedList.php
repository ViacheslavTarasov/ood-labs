<?php

namespace Tests\Lab02;

class NotifiedList
{
    private $list;

    public function getList()
    {
        return $this->list;
    }

    public function add($item): void
    {
        $this->list[] = $item;
    }
}