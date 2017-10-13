<?php namespace Controller;
use DAOS\BeerDAO as BeerDAO;
use Model\Beer as Beer;
class GestionBeerController {

  public function __construct() {
    require 'AdminViews/GestionLobby.php';
  }

  public function Index() {}

  public function SubmitBeer(
    $name = null, $description = null, $price = null, $ibu = null, $srm = null, $graduation = null, $image = null) {
    /*
    La primera vez que entra llama a la vista.
    Cuando se envia el form desde la vista, la funcion recibe la nueva Cerveza
    y aplica la logica necesaria
    */
    if (isset($name)) {
      $beer = new Beer($name, $description, $price, $ibu, $srm, $graduation, $image);
      $alert = "green";
      $msj = "Cerveza añadida correctamente: ".$name;
    }
    require 'AdminViews/SubmitBeer.php';
    #TODO require footer
  }

  public function UpdateBeer($id_beer = null, $name = null, $description = null, $price = null, $ibu = null, $srm = null, $graduation = null, $image = null) {
    $beerDAO = new BeerDAO();
    $list = $beerDAO->SelectAll();
    if (isset($name)) {
      $beer = new Beer($id_beer, $name, $description, $price, $ibu, $srm, $graduation, $image);
      $alert = "green";
      $msj = "Cerveza modificada correctamente: ".$name;
    }
    require 'AdminViews/UpdateBeer.php';
  }

  public function DeleteBeer($name = null, $id_beer = null) {
    if (isset($name)) {
      // TODO beerDAO->Delete($id_beer);
      $alert = "green";
      $msj = "Cerveza eliminada: ".$name." (id ".$id_beer.")";
    }
    $beerDAO = new BeerDAO();
    $list = $beerDAO->SelectAll();
    require 'AdminViews/DeleteBeer.php';
  }
} ?>
