<?php namespace DAOS;

use DAOS\Connection as Connection;
use DAOS\StateDAO as StateDAO;
use DAOS\ClientDAO as ClientDAO;
use DAOS\SubsidiaryDAO as SubsidiaryDAO;
use DAOS\OrderLineDAO as OrderLineDAO;
use DAOS\SendDAO as SendDAO;
use Model\Order as Order;

class OrderDAO extends SingletonDAO implements IDAO {

  private $pdo;
  protected $table = 'Orders';
  private $stateDAO;
  private $clientDAO;
  private $subsidiaryDAO;
  private $orderLineDAO;
  private $sendDAO;

  protected function __construct() {
    $this->pdo = Connection::getInstance();
    $this->stateDAO = StateDAO::getInstance();
    $this->clientDAO = ClientDAO::getInstance();
    $this->subsidiaryDAO = SubsidiaryDAO::getInstance();
    $this->orderLineDAO = OrderLineDAO::getInstance();
    $this->sendDAO = SendDAO::getInstance();
  }

  public function Insert($object) {
    try {
      $stmt = $this->pdo->Prepare("INSERT INTO ".$this->table." (order_date, id_state, id_client, total, id_subsidiary, id_send) values (?,?,?,?,?,?)");
      $aux_id_send = ($object->getSend() !== null) ? $object->getSend()->getId() : null;
      $stmt->execute(array(
        $object->getOrderDate(),
        $object->getState()->getId(),
        $object->getClient()->getId(),
        $object->getTotal(),
        $object->getSubsidiary()->getId(),
        $aux_id_send
      ));
      $object->setOrderNumber($this->pdo->LastInsertId());
      foreach ($object->getOrderLines() as $order_line) {
        $this->orderLineDAO->Insert($order_line, $object->getOrderNumber());
      }
      return $object;
    } catch (\PDOException $e) {
      //throw $e;
      $this->pdo->getException($e);
    }
  }

  public function Delete($object) {
    try {
      $stmt = $this->pdo->Prepare("DELETE FROM ".$this->table." WHERE order_number = ?");
      return ($stmt->execute(array($object->getOrderNumber())));
    } catch (\PDOException $e) {
      //throw $e;
      $this->pdo->getException($e);
    }
  }

  public function SelectByID($id) {
    try {
      $stmt = $this->pdo->Prepare("SELECT * FROM ".$this->table." where order_number = ? LIMIT 1");
      if ($stmt->execute(array($id))) {
        if ($result = $stmt->fetch()) {
          $state = $this->stateDAO->SelectByID($result['id_state']);
          $client = $this->clientDAO->SelectByID($result['id_client']);
          $subsidiary = $this->subsidiaryDAO->SelectByID($result['id_subsidiary']);
          $orderLines = $this->orderLineDAO->SelectAllFromOrderNumber($result['order_number']);
          $order = new Order(
            $result['order_date'],
            $state,
            $client,
            $subsidiary
          );
          foreach ($orderLines as $line) {
            $order->AddOrderLine($line);
          }
          $order->setOrderNumber($result['order_number']);
          return $order;
        }
      }
    } catch (\PDOException $e) {
      //throw $e;
      $this->pdo->getException($e);
    }
  }

  public function SelectAll() {
    try {
      $list = array();
      $stmt = $this->pdo->Prepare("SELECT * FROM ".$this->table."");
      if ($stmt->execute()) {
        while ($result = $stmt->fetch()) {
          $state = $this->stateDAO->SelectByID($result['id_state']);
          $client = $this->clientDAO->SelectByID($result['id_client']);
          $subsidiary = $this->subsidiaryDAO->SelectByID($result['id_subsidiary']);
          $orderLines = $this->orderLineDAO->SelectAllFromOrderNumber($result['order_number']);
          $order = new Order(
            $result['order_date'],
            $state,
            $client,
            $subsidiary
          );
          foreach ($orderLines as $line) {
            $order->AddOrderLine($line);
          }
          $order->setOrderNumber($result['order_number']);
          array_push($list, $order);
        }
        return $list;
      }
    } catch (\PDOException $e) {
      //throw $e;
      $this->pdo->getException($e);
    }
  }

  public function SelectAllFromClientDNI($client_dni) {
    try {
      $list = array();
      $stmt = $this->pdo->Prepare("SELECT o.* FROM ".$this->table." o INNER JOIN Clients c ON o.id_client = c.id_client WHERE c.dni = ?");
      if ($stmt->execute(array($client_dni))) {
        while ($result = $stmt->fetch()) {
          $state = $this->stateDAO->SelectByID($result['id_state']);
          $client = $this->clientDAO->SelectByID($result['id_client']);
          $subsidiary = $this->subsidiaryDAO->SelectByID($result['id_subsidiary']);
          $orderLines = $this->orderLineDAO->SelectAllFromOrderNumber($result['order_number']);
          $order = new Order(
            $result['order_date'],
            $state,
            $client,
            $subsidiary
          );
          foreach ($orderLines as $line) {
            $order->AddOrderLine($line);
          }
          $order->setOrderNumber($result['order_number']);
          array_push($list, $order);
        }
        return $list;
      }
    } catch (\PDOException $e) {
      //throw $e;
      $this->pdo->getException($e);
    }
  }

  public function SelectByClientDNIBetweenDates($client_dni, $from, $to) {
    try {
      $list = array();
      $stmt = $this->pdo->Prepare("SELECT o.* FROM ".$this->table." o INNER JOIN Clients c ON o.id_client = c.id_client WHERE c.dni = ? && DATE(o.order_date) BETWEEN ? AND ? ");
      if ($stmt->execute(array($client_dni,$from,$to))) {
        while ($result = $stmt->fetch()) {
          $state = $this->stateDAO->SelectByID($result['id_state']);
          $client = $this->clientDAO->SelectByID($result['id_client']);
          $subsidiary = $this->subsidiaryDAO->SelectByID($result['id_subsidiary']);
          $orderLines = $this->orderLineDAO->SelectAllFromOrderNumber($result['order_number']);
          $order = new Order(
            $result['order_date'],
            $state,
            $client,
            $subsidiary
          );
          foreach ($orderLines as $line) {
            $order->AddOrderLine($line);
          }
          $order->setOrderNumber($result['order_number']);
          array_push($list, $order);
        }
        return $list;
      }
    } catch (\PDOException $e) {
      //throw $e;
      $this->pdo->getException($e);
    }
  }

  public function SelectAllFromSubsidiary($id_subsidiary) {
    try {
      $list = array();
      $stmt = $this->pdo->Prepare("SELECT * FROM ".$this->table." WHERE id_subsidiary = ?");
      if ($stmt->execute(array($id_subsidiary))) {
        while ($result = $stmt->fetch()) {
          $state = $this->stateDAO->SelectByID($result['id_state']);
          $client = $this->clientDAO->SelectByID($result['id_client']);
          $subsidiary = $this->subsidiaryDAO->SelectByID($result['id_subsidiary']);
          $orderLines = $this->orderLineDAO->SelectAllFromOrderNumber($result['order_number']);
          $order = new Order(
            $result['order_date'],
            $state,
            $client,
            $subsidiary
          );
          foreach ($orderLines as $line) {
            $order->AddOrderLine($line);
          }
          $order->setOrderNumber($result['order_number']);
          array_push($list, $order);
        }
        return $list;
      }
    } catch (\PDOException $e) {
      //throw $e;
    $this->pdo->getException($e);
    }
  }

  public function SelectAllBetweenDates($from, $to) {
    try {
      $list = array();
      $stmt = $this->pdo->Prepare("SELECT * FROM ".$this->table." WHERE order_date BETWEEN ? AND ?");
      if ($stmt->execute(array($from, $to))) {
        while ($result = $stmt->fetch()) {
          $state = $this->stateDAO->SelectByID($result['id_state']);
          $client = $this->clientDAO->SelectByID($result['id_client']);
          $subsidiary = $this->subsidiaryDAO->SelectByID($result['id_subsidiary']);
          $orderLines = $this->orderLineDAO->SelectAllFromOrderNumber($result['order_number']);
          $order = new Order(
            $result['order_date'],
            $state,
            $client,
            $subsidiary
          );
          foreach ($orderLines as $line) {
            $order->AddOrderLine($line);
          }
          $order->setOrderNumber($result['order_number']);
          array_push($list, $order);
        }
        return $list;
      }
    } catch (\PDOException $e) {
      //throw $e;
      $this->pdo->getException($e);
    }
  }

  public function Update($object) {
    try {
      $stmt = $this->pdo->Prepare("UPDATE ".$this->table." SET order_date = ?, id_state = ?, id_client = ?, id_subsidiary = ? WHERE order_number = ?");
      $stmt->execute(array(
        $object->getOrderDate(),
        $object->getState()->getId(),
        $object->getClient()->getId(),
        $object->getSubsidiary()->getId(),
        $object->getOrderNumber()
      ));
      return $object;
    } catch (\PDOException $e) {
      //throw $e;
      $this->pdo->getException($e);
    }
  }
} ?>
