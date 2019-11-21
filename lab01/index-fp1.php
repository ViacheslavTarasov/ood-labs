<?php

function duck(callable $display, callable $fly, callable $quack)
{
    return function () use ($display, $fly, $quack) {
        $display();
        $fly();
        $quack();
    };
}

$getCounter = function ($amount) {
    return function () use (&$amount) {
        return ++$amount;
    };
};

$getFlyWings = function () use ($getCounter) {
    $counter = $getCounter(0);
    return function () use ($counter) {
        echo 'fly #' . $counter() . PHP_EOL;
        echo 'FlyWithWings' . PHP_EOL;
    };
};


$flyWithWings = function () {
    echo 'FlyWithWings' . PHP_EOL;
};

$flyNoWay = function () {
};

$quack = function () {
    echo 'Quack' . PHP_EOL;
};
$squeack = function () {
    echo 'Squeack' . PHP_EOL;
};

$mallardDuck = duck(
    function () {
        echo 'I am MallardDuck' . PHP_EOL;
    },
    $getFlyWings(),
    $quack
);

$redHeadDuck = duck(
    function () {
        echo 'I am RedHeadDuck' . PHP_EOL;
    },
    $getFlyWings(),
    $quack
);

$rubberDuck = duck(
    function () {
        echo 'I am RubberDuck' . PHP_EOL;
    },
    $flyNoWay,
    $squeack
);

function play(callable $concreteDuck)
{
    $concreteDuck();
    echo PHP_EOL;
}

play($mallardDuck);
play($mallardDuck);
play($redHeadDuck);
play($rubberDuck);