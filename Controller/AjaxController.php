<?php namespace Controller;
use DAOS\BeerDAO as BeerDAO;
use Model\Beer as Beer;

use DAOS\PackagingDAO as PackagingDAO;
use Model\Packaging as Packaging;

use DAOS\SubsidiaryDAO as SubsidiaryDAO;
use Model\Subsidiary as Subsidiary;

class AjaxController {

  public function GetBeer($id) {
    $beerDAO = new BeerDAO();
    $beer = $beerDAO->SelectByID($id);
    echo json_encode($beer->toJson());
  }

  public function GetPackaging($id) {
    $packagingDAO = new PackagingDAO();
    $packaging = $packagingDAO->SelectByID($id);
    echo json_encode($packaging->toJson());
  }

  public function GetSubsidiary($id) {
    $subsidiaryDAO = new SubsidiaryDAO();
    $subsidiary = $subsidiaryDAO->SelectByID($id);
    echo json_encode($subsidiary->toJson());
  }
} ?>
