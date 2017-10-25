<?php namespace Controller;
use DAOS\BeerDAO as BeerDAO;
class ListaCervezasController {
  public function Index() {
    #$BeerDAO = BeerDAO::getInstance();
    $BeerDAO = BeerDAO::getInstance();
    $cervezas = $BeerDAO->SelectAll();
    require_once 'Views/ListaCervezas.php';
  }
} ?>
