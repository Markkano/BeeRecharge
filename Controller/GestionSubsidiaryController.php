<?php namespace Controller;

use DAOS\SubsidiaryDAO as SubsidiaryDAO;
use Model\Subsidiary as Subsidiary;

class GestionSubsidiaryController {

  public function __construct() {
    require 'AdminViews/GestionLobby.php';
  }

  public function Index() {}

  public function SubmitSubsidiary($lat = 0.0, $lon = 0.0, $address = null, $phone = null) {
    if (isset($address)) {
      $subsidiary = new Subsidiary($address, $phone, $lat, $lon);
      $alert = "green";
      $msj = "Sucursal añadida correctamente: ".$address;
    }
    require 'AdminViews/SubmitSubsidiary.php';
  }

  public function UpdateSubsidiary($lat = 0.0, $lon = 0.0, $id_subsidiary = null, $address = null, $phone = null) {
    $subsidiaryDAO = new SubsidiaryDAO();
    $list = $subsidiaryDAO->SelectAll();
    if (isset($address)) {
      $subsidiary = new Subsidiary($address, $phone, $lat, $lon);
      $alert = "green";
      $msj = "Sucursal modificada correctamente: ".$address;
    }
    require 'AdminViews/UpdateSubsidiary.php';
  }

  public function DeleteSubsidiary($address = null, $id_subsidiary = null) {
    if (isset($address)) {
      // TODO SubsidiaryDAO->Delete($id_subsidiary);
      $alert = "green";
      $msj = "Sucursal eliminada: ".$address." (id ".$id_subsidiary.")";
    }
    $subsidiaryDAO = new SubsidiaryDAO();
    $list = $subsidiaryDAO->SelectAll();
    require 'AdminViews/DeleteSubsidiary.php';
  }
}
