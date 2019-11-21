<?php

function duck(callable $display)
{
    return function (callable $fly, callable $quack) use ($display) {
        $display();
        $fly();
        $quack();
    };
}

$flyWithWings = function () {
    echo 'FlyWithWings' . PHP_EOL;
};

$flyNoWay = function () {
    echo 'I don\'t fly' . PHP_EOL;
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
    }
);

$redHeadDuck = duck(
    function () {
        echo 'I am RedHeadDuck' . PHP_EOL;
    }
);

$rubberDuck = duck(
    function () {
        echo 'I am RubberDuck' . PHP_EOL;
    }
);

function play(callable $concreteDuck, callable $fly, callable $quack)
{
    $concreteDuck($fly, $quack);
    echo PHP_EOL;
}

play($mallardDuck, $flyWithWings, $quack);
play($redHeadDuck, $flyNoWay, $quack);
play($redHeadDuck, $flyWithWings, $quack);
play($rubberDuck, $flyNoWay, $squeack);