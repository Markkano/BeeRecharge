<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'Config/Config.php';
require_once 'Config/Autoload.php';
use Config\Autoload as Autoload;
Autoload::Start();
use Config\Request as Request;
use Config\Router as Router;

session_start();

$request = Request::getInstance();
Router::Route($request);
?>
