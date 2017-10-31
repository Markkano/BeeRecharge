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
      $client = $this->clientDAO->SelectByDNI($client_dni);
      if (isset($client)) {
        $list = $this->orderDAO->SelectAllFromClientDNI($client_dni);
        if (empty($list)) {
          $msj = "El Cliente no posee pedidos";
          $alert = "green";
        }
      } else {
        $msj = "No se encontro el Cliente";
        $alert = "green";
      }
    }
    require_once 'AdminViews/FilterOrdersByClient.php';
    if (!empty($list)) {
      require_once 'AdminViews/OrderList.php';
    }
  }

  public function FilterOrdersByDates($from = null, $to = null) {
    if (isset($from) && isset($to)) {
      $list = $this->orderDAO->SelectAllBetweenDates($from, $to);
      if (empty($list)) {
        $msj = "No se han registrado pedidos entre estas fechas";
        $alert = "green";
      }
    }
    require_once 'AdminViews/FilterOrdersByDates.php';
    if (!empty($list)) {
      require_once 'AdminViews/OrderList.php';
    }
  }

  public function FilterOrdersBySubsidiary($id_subsidiary = null) {
    if(isset($id_subsidiary)) {
      $subsidiary = $this->subsidiaryDAO->SelectById($id_subsidiary);
      if (isset($subsidiary)) {
        $list = $this->orderDAO->SelectAllFromSubsidiary($id_subsidiary);
        if (empty($list)) {
          $msj = "No se han registrado pedidos para esta Sucursal";
          $alert = "green";
        }
      } else {
        $msj = "No se encontro la Sucursal";
        $alert = "green";
      }
    }
    $subsidiary_list = $this->subsidiaryDAO->SelectAll();
    require_once 'AdminViews/FilterOrdersBySubsidiary.php';
    if (!empty($list)) {
      require_once 'AdminViews/OrderList.php';
    }
  }

  public function ConsultSoldLiters($from = null, $to = null) {
    require_once 'AdminViews/ConsultSoldLiters.php';
  }
} ?>
