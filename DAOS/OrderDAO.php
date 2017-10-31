<?php namespace DAOS;
use DAOS\Connection as Connection;
use DAOS\StateDAO as StateDAO;
use DAOS\ClientDAO as ClientDAO;
use DAOS\SubsidiaryDAO as SubsidiaryDAO;
use DAOS\OrderLineDAO as OrderLineDAO;
use Model\Order as Order;
class OrderDAO extends SingletonDAO implements IDAO {

  private $pdo;
  protected $table = 'Orders';
  /*
  private $state;
	private $client;
	private $subsidiary;
	private $orderLines;
  */
  private $stateDAO;
  private $clientDAO;
  private $subsidiaryDAO;
  private $orderLineDAO;

  public function __construct() {
    $this->pdo = Connection::getInstance();
    $this->stateDAO = StateDAO::getInstance();
    $this->clientDAO = ClientDAO::getInstance();
    $this->subsidiaryDAO = SubsidiaryDAO::getInstance();
    $this->orderLineDAO = OrderLineDAO::getInstance();
  }

  public function Insert($object) {
    $stmt = $this->pdo->Prepare("INSERT INTO ".$this->table." (order_date, id_state, id_client, id_subsidiary) values (?,?,?,?,?)");
    $stmt->execute(array(
      $object->getOrderDate(),
      $object->getState()->getId(),
      $object->getClient()->getId(),
      $object->getSubsidiary()->getId()
    ));
    $object->setOrderNumber($this->pdo->LastInsertId());
    if($stmt->errorCode() == 0) {
      return null;
    } else {
        $errors = $stmt->errorInfo();
        return $errors[2];
    }
  }

  public function Delete($object) {
    $stmt = $this->pdo->Prepare("DELETE FROM ".$this->table." WHERE order_number = ?");
    $stmt->execute(array($object->getOrderNumber()));
    if($stmt->errorCode() == 0) {
      return null;
    } else {
        $errors = $stmt->errorInfo();
        return $errors[2];
    }
  }

/*
private order_number;
private order_date;
private state;
private client;
private subsidiary;
private orderLines;
*/
  public function SelectByID($id) {
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
            $order->NewOrderLine($line);
        }
        $order->setOrderNumber($result['order_number']);
      }
    }
    if($stmt->errorCode() == 0) {
      if (isset($order)) {
        return $order;
      } else {
        return null;
      }
    } else {
        $errors = $stmt->errorInfo();
        return $errors[2];
    }
  }

  public function SelectAll() {
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
            $order->NewOrderLine($line);
        }
        $order->setOrderNumber($result['order_number']);
        array_push($list, $order);
      }
    }
    if($stmt->errorCode() == 0) {
      return $list;
    } else {
        $errors = $stmt->errorInfo();
        return $errors[2];
    }
  }

  public function SelectAllFromClientDNI($client_dni) {
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
            $order->NewOrderLine($line);
        }
        $order->setOrderNumber($result['order_number']);
        array_push($list, $order);
      }
    }
    if($stmt->errorCode() == 0) {
      return $list;
    } else {
        $errors = $stmt->errorInfo();
        return $errors[2];
    }
  }

  public function SelectAllFromSubsidiary($id_subsidiary) {
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
            $order->NewOrderLine($line);
        }
        $order->setOrderNumber($result['order_number']);
        array_push($list, $order);
      }
    }
    if($stmt->errorCode() == 0) {
      return $list;
    } else {
        $errors = $stmt->errorInfo();
        return $errors[2];
    }
  }

  public function SelectAllBetweenDates($from, $to) {
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
            $order->NewOrderLine($line);
        }
        $order->setOrderNumber($result['order_number']);
        array_push($list, $order);
      }
    }
    if($stmt->errorCode() == 0) {
      return $list;
    } else {
        $errors = $stmt->errorInfo();
        return $errors[2];
    }
  }

  public function Update($object) {
    $stmt = $this->pdo->Prepare("UPDATE ".$this->table." SET order_date = ?, id_state = ?, id_client = ?, id_subsidiary = ? WHERE order_number = ?");
    $stmt->execute(array(
      $object->getOrderDate(),
      $object->getState()->getId(),
      $object->getClient()->getId(),
      $object->getSubsidiary()->getId(),
      $object->getOrderNumber()
    ));
    if($stmt->errorCode() == 0) {
      return null;
    } else {
        $errors = $stmt->errorInfo();
        return $errors[2];
    }
  }
} ?>
