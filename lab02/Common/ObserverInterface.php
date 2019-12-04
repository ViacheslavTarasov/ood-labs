<?php

namespace Lab02\Common;

interface ObserverInterface
{
    public function update(ObservableInterface $observable);
}