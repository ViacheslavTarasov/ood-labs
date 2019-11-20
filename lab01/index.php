<?php

use SimUDuck\Behavior\FlyWithWings;
use SimUDuck\Duck\DecoyDuck;
use SimUDuck\Duck\Duck;
use SimUDuck\Duck\MallardDuck;
use SimUDuck\Duck\RedHeadDuck;
use SimUDuck\Duck\RubberDuck;

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

$mallardDuck = new MallardDuck();
$redHeadDuck = new RedHeadDuck();
$rubberDuck = new RubberDuck();
$decoyDuck = new DecoyDuck();

play($mallardDuck);
play($redHeadDuck);
play($rubberDuck);
play($decoyDuck);

$decoyDuck->setFlyBehavior(new FlyWithWings());
play($decoyDuck);
play($decoyDuck);