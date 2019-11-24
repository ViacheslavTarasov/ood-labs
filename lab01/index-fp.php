<?php

use SimUDuckFP\Duck\DecoyDuck;
use SimUDuckFP\Duck\Duck;
use SimUDuckFP\Duck\MallardDuck;
use SimUDuckFP\Duck\RedHeadDuck;
use SimUDuckFP\Duck\RubberDuck;

spl_autoload_register(function ($class) {
    require str_replace('\\', '/', $class) . '.php';
});

function play(Duck $duck)
{
    $duck->display();
    $duck->performFly();
    $duck->performQuack();
    $duck->performDance();
    print_r(PHP_EOL);

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
$muteQuack = function () {
    echo 'muteQuack' . PHP_EOL;
};
$squeack = function () {
    echo 'Squeack' . PHP_EOL;
};
$waltzDance = function () {
    echo 'WaltzDance' . PHP_EOL;
};
$minuetDance = function () {
    echo 'MinuetDance' . PHP_EOL;
};
$danceNoWay = function () {
    echo 'DanceNoWay' . PHP_EOL;
};

$mallardDuck = new MallardDuck($flyWithWings, $quack, $waltzDance);
$redHeadDuck = new RedHeadDuck($flyWithWings, $quack, $minuetDance);
$rubberDuck = new RubberDuck($flyNoWay, $squeack, $danceNoWay);
$decoyDuck = new DecoyDuck($flyNoWay, $muteQuack, $danceNoWay);

play($mallardDuck);
play($redHeadDuck);
play($rubberDuck);
play($decoyDuck);

$decoyDuck->setDanceBehavior($waltzDance);
play($decoyDuck);