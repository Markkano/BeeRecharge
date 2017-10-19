<?php namespace Controller;

use DAOS\SubsidiaryDAO as SubsidiaryDAO;
use Model\Subsidiary as Subsidiary;
use Controller\GestionController as GestionController;

class GestionSubsidiaryController extends GestionController {

  public function __construct() {
    self::$roles = array('Admin');
    parent::__construct();
  }

  public function Index() {}

  public function SubmitSubsidiary($lat = 0.0, $lon = 0.0, $address = null, $phone = null) {
    $subsidiaryDAO = new SubsidiaryDAO();
    if (isset($address)) {
      $subsidiary = new Subsidiary($address, $phone, $lat, $lon);
      $subsidiaryDAO->Insert($subsidiary);
      $alert = "green";
      $msj = "Sucursal añadida correctamente: ".$subsidiary->getAddress()." id(".$subsidiary->getId().")";
    }
    require 'AdminViews/SubmitSubsidiary.php';
  }

  public function UpdateSubsidiary($lat = 0.0, $lon = 0.0, $id_subsidiary = null, $address = null, $phone = null) {
    $subsidiaryDAO = new SubsidiaryDAO();
    if (isset($address)) {
      $subsidiary = new Subsidiary($address, $phone, $lat, $lon);
      $subsidiary->setId($id_subsidiary);
      $subsidiaryDAO->Update($subsidiary);
      $alert = "green";
      $msj = "Sucursal modificada correctamente: ".$subsidiary->getAddress();
    }
    $list = $subsidiaryDAO->SelectAll();
    require 'AdminViews/UpdateSubsidiary.php';
  }

  public function DeleteSubsidiary($address = null, $id_subsidiary = null) {
    $subsidiaryDAO = new SubsidiaryDAO();
    if (isset($address)) {
      $subsidiaryDAO->DeleteById($id_subsidiary);
      $alert = "green";
      $msj = "Sucursal eliminada: ".$address." (id ".$id_subsidiary.")";
    }
    $list = $subsidiaryDAO->SelectAll();
    require 'AdminViews/DeleteSubsidiary.php';
  }
}
