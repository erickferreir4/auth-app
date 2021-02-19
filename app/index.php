<?php declare(strict_types=1);

require __DIR__ . '/core/init.php';
//require __DIR__ . '/vendor/autoload.php';

//phpinfo();

$app = new app\controller\AppController;
$app->router();

