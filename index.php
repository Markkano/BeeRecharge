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

$request = Request::getInstance();
/*echo "URL: " . $_GET['url'];
echo "<br/> Controller: ";
echo($request->getController());
echo "<br/> Method: ";
echo($request->getMethod());
echo "<br/> Parameters: ";
print_r($request->getParameters());
echo "<br/>";*/
Router::Route($request);
?>
