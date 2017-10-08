<?php namespace Config;

class Autoload {
  public static function Start() {
    spl_autoload_register(function($classPath) {
      $classFile = ROOT . str_replace("\\", "/", $classPath).".php";
      include_once $classFile;
    });
  }
} ?>
