<?php namespace Config;
class Router {
  /*
  Direcciona la pagina solicitada, no hay logica de negocios,
  solo redirecciona al controlador especifico.
  */
  public static function Route(Request $request) {
    $controller = $request->getController() . 'Controller';
    $method = $request->getMethod();
    $parameters = $request->getParameters();

    $show = 'Controller\\'.$controller;

    $controller = new $show;

    if(!isset($parameters)) {
      #paso contr y met y de ese objeto controller invoca method especifico. paso objeto y method y lo llama
      call_user_func(array($controller, $method));
    } else {
      call_user_func_array(array($controller, $method), $parameters);
    }
  }
} ?>
