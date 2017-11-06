<?php namespace Controller;

use DAOS\OrderDAO as OrderDAO;
use Model\Order as Order;
use DAOS\ClientDAO as ClientDAO;
use DAOS\SubsidiaryDAO as SubsidiaryDAO;

class GestionConsultsController extends GestionController {

  private $orderDAO;
  private $clientDAO;
  private $subsidiaryDAO;


  public function __construct() {
    self::$roles = array('Admin', 'Empleado', 'Vendedor', 'Flaquito');
    parent::__construct();
    $this->orderDAO = OrderDAO::getInstance();
    $this->clientDAO = ClientDAO::getInstance();
    $this->subsidiaryDAO = SubsidiaryDAO::getInstance();
  }

  public function Index() {}

  public function FilterOrdersByClient($client_dni = null) {
    if(isset($client_dni)) {
      try {
        $client = $this->clientDAO->SelectByDNI($client_dni);
        if (isset($client)) {
          $list = $this->orderDAO->SelectAllFromClientDNI($client_dni);
          if (empty($list)) {
            throw new \Exception("El cliente no posee pedidos", 1);
          }
        } else {
          throw new \Exception("No se encontro el Cliente", 1);
        }
      } catch (\Exception $e) {
        $alert = "yellow";
        $msj = $e->getMessage();
      }
    }
    require_once 'AdminViews/FilterOrdersByClient.php';
    if (!empty($list)) {
      require_once 'AdminViews/OrderList.php';
    }
  }

  public function FilterOrdersByDates($from = null, $to = null) {
    if (isset($from) && isset($to)) {
      try {
        $list = $this->orderDAO->SelectAllBetweenDates($from, $to);
        if (empty($list)) {
          throw new \Exception("No se han registrado pedidos entre estas fechas", 1);
        }
      } catch (\Exception $e) {
        $alert = "yellow";
        $msj = $e->getMessage();
      }
    }
    require_once 'AdminViews/FilterOrdersByDates.php';
    if (!empty($list)) {
      require_once 'AdminViews/OrderList.php';
    }
  }

  public function FilterOrdersBySubsidiary($id_subsidiary = null) {
    if(isset($id_subsidiary)) {
      try {
        $subsidiary = $this->subsidiaryDAO->SelectById($id_subsidiary);
        if (isset($subsidiary)) {
          $list = $this->orderDAO->SelectAllFromSubsidiary($id_subsidiary);
          if (empty($list)) {
            throw new \Exception("No se han registrado pedidos para esta Sucursal", 1);
          }
        } else {
          throw new \Exception("No se encontro la sucursal", 1);
        }
      } catch (\Exception $e) {
        $alert = "yellow";
        $msj = $e->getMessage();
      }
    }
    try {
      $subsidiary_list = $this->subsidiaryDAO->SelectAll();
    } catch (\Exception $e) {
      $alert = "yellow";
      $msj = $e->getMessage();
    }    
    require_once 'AdminViews/FilterOrdersBySubsidiary.php';
    if (!empty($list)) {
      require_once 'AdminViews/OrderList.php';
    }
  }

  public function ConsultSoldLiters($from = null, $to = null) {
    require_once 'AdminViews/ConsultSoldLiters.php';
  }
} ?>
