<?php
require_once './../resources/Autoload.php';

$configMain = require './../main/config.php';
$configLocal = require './../main/config-local.php';
$config = array_replace_recursive($configMain, $configLocal);

spl_autoload_register([new \app\resources\Autoload(), 'loadClass']);

$renderService = new \app\resources\PHPRenderService();
$app = new \app\main\App($renderService);

if (isset($_POST['provider'], $_POST['city'])) {
    $provider = $_POST['provider'];
    try {
        $app->setDataProvider(new $provider($config));
        $app->renderWeatherForCity($_POST['city']);
    } catch (Exception $e) {
        $app->render('404');
    }
} else {
    $app->render();
}