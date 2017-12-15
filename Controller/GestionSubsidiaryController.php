<?php namespace Controller;

use DAOS\SubsidiaryDAO as SubsidiaryDAO;
use Model\Subsidiary as Subsidiary;
use Controller\GestionController as GestionController;

class GestionSubsidiaryController extends GestionController {

  private $subsidiaryDAO;

  public function __construct() {
    self::$roles = array('Admin');
    try {
      $this->subsidiaryDAO = SubsidiaryDAO::getInstance();
    } catch (\Exception $e) {
      $alert = "red";
      $msj = "Error: Ocurrio un problema al conectar con la Base de Datos";
    } finally {
      parent::__construct();
      if (isset($msj) && isset($alert)) {
        $this->Alert($msj, $alert);
        die();
      }
    }
  }

  public function Index() {}

  private function getSubsidiaryList() {
    try {
      $list = $this->subsidiaryDAO->SelectAll();
    } catch (\Exception $e) {
      $alert = "red";
      $msj = "Ocurrio un problema al traer la lista de Sucursales";
      $this->Alert($msj, $alert);
      $list = array();
    }
    return $list;
  }

  public function Submit() {
    require_once 'AdminViews/SubmitSubsidiary.php';
  }

  public function SubmitSubsidiary($lat = 0.0, $lon = 0.0, $address = null, $phone = null) {
    if (isset($address) && isset($phone)) {
      $subsidiary = new Subsidiary($address, $phone, $lat, $lon);
      try {
        $subsidiary = $this->subsidiaryDAO->Insert($subsidiary);
        if (isset($subsidiary)) {
          $alert = "green";
          $msj = "Sucursal añadida correctamente: ".$subsidiary->getAddress();
          $this->Alert($msj, $alert);
        } else {
          throw new \Exception("", 1);
        }
      } catch (\PDOException $e) {
        $error = $e->errorInfo;
        $alert = "yellow";
        if ($error[1] == '1062') { //Entrada duplicada
          $msj = "Ya existe una sucursal con esa Direccion";
        } else {
          $msj = "Ocurrio un problema con la Base de Datos: error ".$error[1];
        }
        $this->Alert($msj, $alert);
      } catch (\Exception $e) {
        $alert = "yellow";
        $msj = "Ocurrio un problema";
        $this->Alert($msj, $alert);
      }
    }
    $this->Submit();
  }

  public function Update($id_subsidiary = null) {
    $list = $this->getSubsidiaryList();
    require_once 'AdminViews/UpdateSubsidiary.php';
  }

  public function UpdateSubsidiary($lat = 0.0, $lon = 0.0, $id_subsidiary = null, $address = null, $phone = null) {
    if (isset ($id_subsidiary) && isset($address) && isset($phone)) {
      $subsidiary = new Subsidiary($address, $phone, $lat, $lon);
      $subsidiary->setId($id_subsidiary);
      try {
          $subsidiary = $this->subsidiaryDAO->Update($subsidiary);
          if (isset($subsidiary)) {
            $alert = "green";
            $msj = "Sucursal modificada correctamente: ".$subsidiary->getAddress();
            $this->Alert($msj, $alert);
          } else {
            throw new \Exception("", 1);
          }
      } catch (\PDOException $e) {
        $error = $e->errorInfo;
        $alert = "yellow";
        if ($error[1] == '1062') { //Entrada duplicada
          $msj = "Ya existe otra sucursal con esa Direccion";
        } else {
          $msj = "Ocurrio un problema con la Base de Datos: error ".$error[1];
        }
        $this->Alert($msj, $alert);
      } catch (\Exception $e) {
        $alert = "yellow";
        $msj = "Ocurrio un problema al actualizar la sucursal";
        $this->Alert($msj, $alert);
      }
    }
    $this->Update($id_subsidiary);
  }

  public function Delete() {
    $list = $this->getSubsidiaryList();
    require_once 'AdminViews/DeleteSubsidiary.php';
  }

  public function DeleteSubsidiary($address = null, $id_subsidiary = null) {
    if (isset($address) && isset($id_subsidiary)) {
      try {
        if ($this->subsidiaryDAO->DeleteById($id_subsidiary)) {
          $alert = "green";
          $msj = "Sucursal eliminada: ".$address." (id ".$id_subsidiary.")";
          $this->Alert($msj, $alert);
        } else {
          throw new \Exception("", 1);
        }
      } catch (\PDOException $e) {
        $error = $e->errorInfo;
        $alert = "yellow";
        if ($error[1] == '1451') {
          $msj = "No se pudo eliminar, la sucursal ya posee pedidos";
        } else {
          $msj = "Ocurrio un problema con la Base de Datos: error ".$error[1];
        }
        $this->Alert($msj, $alert);
      } catch (\Exception $e) {
        $alert = "yellow";
        $msj = "Ocurrio un problema al eliminar la sucursal";
        $this->Alert($msj, $alert);
      }
    }
    $this->Delete();
  }

  public function ManageMarkers($id_subsidiary = null, $lat = null, $lon = null) {
    if (isset($id_subsidiary)) {
      try {
        $subsidiary = $this->subsidiaryDAO->SelectById($id_subsidiary);
        $subsidiary->setLat($lat);
        $subsidiary->setLon($lon);
        $subsidiary = $this->subsidiaryDAO->Update($subsidiary);
        if (isset($subsidiary)) {
          $alert = "green";
          $msj = "Sucursal modificada correctamente: ".$subsidiary->getAddress();
          $this->Alert($msj, $alert);
        } else {
          throw new \Exception("", 1);
        }
      } catch (\Exception $e) {
        $alert = "yellow";
        $msj = "Ocurrio un problema";
        $this->Alert($msj, $alert);
      }
    }
    $list = $this->getSubsidiaryList();
    require_once 'AdminViews/SubsidiaryMarkers.php';
  }
}
