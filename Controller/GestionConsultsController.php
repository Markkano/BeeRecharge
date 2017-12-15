<?php namespace Controller;

use DAOS\OrderDAO as OrderDAO;
use Model\Order as Order;
use DAOS\ClientDAO as ClientDAO;
use DAOS\SubsidiaryDAO as SubsidiaryDAO;
use DAOS\StateDAO as StateDAO;

class GestionConsultsController extends GestionController {

  private $orderDAO;
  private $clientDAO;
  private $subsidiaryDAO;
  private $stateDAO;


  public function __construct() {
    self::$roles = array('Admin', 'Empleado', 'Vendedor', 'Flaquito');
    parent::__construct();
    $this->orderDAO = OrderDAO::getInstance();
    $this->clientDAO = ClientDAO::getInstance();
    $this->subsidiaryDAO = SubsidiaryDAO::getInstance();
    $this->stateDAO = StateDAO::getInstance();
  }

  public function Index() {}

  private function List($list) {
    $state_list = $this->stateDAO->SelectAll();
    require_once 'AdminViews/OrderList.php';
  }

  public function FilterOrdersByClient($client_dni = null) {
    if(isset($client_dni)) {
      try {
        $client = $this->clientDAO->SelectByDNI($client_dni);
        if (isset($client)) {
          $list = $this->orderDAO->SelectAllFromClientDNI($client_dni);
          if (empty($list)) {
            $alert = "green";
            $msj = "El cliente no posee pedidos";
            $this->Alert($msj, $alert);
          }
        } else {
          $alert = "green";
          $msj = "No se encontro el Cliente";
          $this->Alert($msj, $alert);
        }
      } catch (\Exception $e) {
        $alert = "yellow";
        $msj = "Ocurrio un problema al traer la lista de Ordenes";
        $this->Alert($msj, $alert);
      }
    }
    require_once 'AdminViews/FilterOrdersByClient.php';
    if (!empty($list)) {
      $this->List($list);
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
      $this->List($list);
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
      $this->List($list);
    }
  }

public function ConsultSoldLiters($from = null, $to = null) {
    if (isset($from) && isset($to)) {
      try {
        $list = $this->orderDAO->SelectSendLitersBetweenDatesAndGroupedByBeer($from, $to);
        if (empty($list)) {
          throw new \Exception("No hay pedidos entre estas fechas", 1);
        }
      } catch (\Exception $e) {
        $alert = "yellow";
        $msj = $e->getMessage();
      }
    }
    require_once 'AdminViews/ConsultSoldLiters.php';
    if (!empty($list)) {
      require_once 'AdminViews/OrderListBeers.php';
    }
  }
} ?>
