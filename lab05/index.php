<?php
declare(strict_types=1);

use Lab05\App;

require_once(__DIR__ . '/../vendor/autoload.php');

$app = new App();
$app->run();

/**
 *
 *
 * setTitle Title!
 * insertParagraph end Lorem ipsum
 * insertImage end 100 200 /mnt/hgfs/Projects/ood-labs/lab05/html/pics/monkey.png
 * insertParagraph end  ipsum Lorem
 * insertImage end 300 400 /mnt/hgfs/Projects/ood-labs/lab05/html/pics/shapes.png
 *
 * replaceText 0 new etxt
 *
 * save /mnt/hgfs/Projects/ood-labs/lab05/html/1.html
 */
 