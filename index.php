<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ini_set('memory_limit', '256M');

require_once'Config/Config.php';
require_once'Config/Autoload.php';
use Config\Autoload as Autoload;
Autoload::Start();
use Config\Request as Request;
use Config\Router as Router;

session_start();

function Debug($var) {
  highlight_string("<?php\n\$data =\n" . var_export($var, true) . ";\n?>");
}

$request = Request::getInstance();
/*echo "<br/>";
echo "<b>Controladora:</b>".$request->getController()."<br>";
echo "<b>Metodo:</b>".$request->getMethod()."<br>";
echo "<b>Parametros:</b><br>";
$parameters = $request->getParameters();
if (isset($parameters)) {
  foreach ($parameters as $value) {
    if (is_array($value)) {
      print_r($value);
    } else {
      echo " -".$value."<br/>";
    }
  }
}
echo "<br/>";*/
Router::Route($request);
?>
