<?php namespace Controller;
use DAOS\BeerDAO as BeerDAO;
class ListaCervezasController {
  public function Index() {
    #$BeerDAO = BeerDAO::getInstance();
    $BeerDAO = new BeerDAO();
    $cervezas = $BeerDAO->SelectAll();
    require 'Views/ListaCervezas.php';
  }
} ?>
