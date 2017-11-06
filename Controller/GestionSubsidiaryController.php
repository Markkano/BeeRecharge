<?php namespace Controller;

use DAOS\SubsidiaryDAO as SubsidiaryDAO;
use Model\Subsidiary as Subsidiary;
use Controller\GestionController as GestionController;

class GestionSubsidiaryController extends GestionController {

  private $subsidiaryDAO;

  public function __construct() {
    self::$roles = array('Admin');
    $this->subsidiaryDAO = SubsidiaryDAO::getInstance();
    parent::__construct();
  }

  public function Index() {}

  public function Submit($lat = 0.0, $lon = 0.0, $address = null, $phone = null) {
    if (isset($address)) {
      $subsidiary = new Subsidiary($address, $phone, $lat, $lon);
      try {
        $subsidiary = $this->subsidiaryDAO->Insert($subsidiary);
        if (isset($subsidiary)) {
          $alert = "green";
          $msj = "Sucursal añadida correctamente: ".$subsidiary->getAddress();
        } else {
          $alert = "yellow";
          $msj = "Ocurrio un problema";
        }
      } catch (\Exception $e) {
        $alert = "yellow";
        $msj = $e->getMessage();
      }
    }
    require_once 'AdminViews/SubmitSubsidiary.php';
  }

  public function Update($lat = 0.0, $lon = 0.0, $id_subsidiary = null, $address = null, $phone = null) {
    if (isset ($id_subsidiary) && isset($address) && isset($phone)) {
      $subsidiary = new Subsidiary($address, $phone, $lat, $lon);
      $subsidiary->setId($id_subsidiary);
      try {
          $subsidiary = $this->subsidiaryDAO->Update($subsidiary);
          if (isset($subsidiary)) {
            $alert = "green";
            $msj = "Sucursal modificada correctamente: ".$subsidiary->getAddress();
          } else {
            $alert = "yellow";
            $msj = "Ocurrio un problema";
          }
      } catch (\Exception $e) {
        $alert = "yellow";
        $msj = $e->getMessage();
      }
    }
    $list = $this->subsidiaryDAO->SelectAll();
    require_once 'AdminViews/UpdateSubsidiary.php';
  }

  public function Delete($address = null, $id_subsidiary = null) {
    if (isset($address) && isset($id_subsidiary)) {
      try {
        if ($this->subsidiaryDAO->DeleteById($id_subsidiary)) {
          $alert = "green";
          $msj = "Sucursal eliminada: ".$address." (id ".$id_subsidiary.")";
        } else {
          $alert = "yellow";
          $msj = "Ocurrio un problema";
        }
      } catch (\Exception $e) {
        $alert = "yellow";
        $msj = $e->getMessage();
      }
    }
    $list = $this->subsidiaryDAO->SelectAll();
    require_once 'AdminViews/DeleteSubsidiary.php';
  }

  public function ManageMarkers($id_subsidiary = null, $lat = null, $lon = null) {
    if (isset($id_subsidiary)) {
      #echo "id:".$id_subsidiary."  lat:".$lat."  lon:".$lon;
      $subsidiary = $this->subsidiaryDAO->SelectById($id_subsidiary);
      $subsidiary->setLat($lat);
      $subsidiary->setLon($lon);
      $error = $this->subsidiaryDAO->Update($subsidiary);
      if (!isset($error)) {
        $alert = "green";
        $msj = "Sucursal modificada correctamente: ".$subsidiary->getAddress();
      } else {
        $alert = "yellow";
        $msj = "Ocurrio un problema";
      }
    }
    $list = $this->subsidiaryDAO->SelectAll();
    require_once 'AdminViews/SubsidiaryMarkers.php';
  }
}
