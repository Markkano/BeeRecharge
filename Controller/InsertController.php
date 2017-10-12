<?php namespace Controller;
use DAOS\BeerDAO as BeerDAO;
use Model\Beer as Beer;

class InsertController {

  public function Index() {
    require 'Views/insert.php';
  }

  public function Insert($name, $description, $price, $ibu, $srm, $graduation, $image) {
    $BeerDAO = new BeerDAO();
    $beer = new Beer($name, $description, $price, $ibu, $srm, $graduation, $image);
    $BeerDAO->Insert($beer);
    #require 'menu principal';
  }
} ?>
