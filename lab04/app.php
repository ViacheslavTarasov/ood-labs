<?php
declare(strict_types=1);

use Lab04\Canvas\PngCanvas;
use Lab04\Canvas\TextCanvas;
use Lab04\Color\ColorFactory;
use Lab04\Designer\Designer;
use Lab04\Painter\Painter;
use Lab04\Shape\ShapeFactory;

require_once(__DIR__ . '/../vendor/autoload.php');

const IMAGE_PATH = __DIR__ . '/result.png';
/*
 rectangle red 10 20 30 40
 triangle green 100 200 120 410 350 150
 ellipse blue 200 200 100 40
 polygon pink 200 200 8 150
 done
 */
echo 'Shapes Factory' . PHP_EOL
    . 'Commands:' . PHP_EOL
    . 'rectangle <Color> <LeftTopX> <LeftTopX> <BottomRightX> <BottomRightY>' . PHP_EOL
    . 'triangle <Color> <Vertex1X> <Vertex1Y> <Vertex2X> <Vertex2Y> <Vertex3X> <Vertex3Y>' . PHP_EOL
    . 'ellipse <Color> <CenterX> <CenterY> <Width> <Height>' . PHP_EOL
    . 'polygon <Color> <CenterX> <VertexCount> <Radius>' . PHP_EOL
    . 'done' . PHP_EOL;

$colorFactory = new ColorFactory();
$shapeFactory = new ShapeFactory($colorFactory);
$designer = new Designer($shapeFactory);
$stdin = new SplFileObject('php://stdin', 'r');
$draft = $designer->createDraft($stdin);
$painter = new Painter();

$canvas = new PngCanvas(800, 600, IMAGE_PATH);
$painter->drawPicture($draft, $canvas);

$canvas = new TextCanvas(new SplFileObject('php://stdout', 'w'));
$painter->drawPicture($draft, $canvas);


