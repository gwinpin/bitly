<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

define('ROOT', dirname(__FILE__) . '/..');
require_once(ROOT . '/components/Router.php');
require_once(ROOT . '/components/Db.php');
require_once(ROOT . '/components/Bitly.php');
require_once(ROOT . '/controllers/BaseController.php');

$router = new Router();
$router->run();

