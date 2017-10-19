<?php namespace DAOS;
use DAOS\Connection as Connection;
use Model\Staff as Staff;
use DAOS\RoleDAO as RoleDAO;
use Model\Role as Role;
use DAOS\AccountDAO as AccountDAO;
use Model\Account as Account;

class StaffDAO extends SingletonDAO implements IDAO {

  private $AccountDAO;
  private $RoleDAO;

  public function __construct() {
    $this->AccountDAO = new AccountDAO();
    $this->RoleDAO = new RoleDAO();
  }

  public function Insert($object) {
    $pdo = Connection::getInstance();
    $stmt = $pdo->Prepare("INSERT INTO Staff (name, surname, dni, address, phone, salary, id_account, id_role) values (?,?,?,?,?,?,?,?)");
    $stmt->execute(array(
      $object->getName(),
      $object->getSurname(),
      $object->getDni(),
      $object->getAddress(),
      $object->getPhone(),
      $object->getSalary(),
      $object->getAccount()->getId(),
      $object->getRole()->getId()
    ));
    $object->setId($pdo->LastInsertId());
    if($stmt->errorCode() == 0) {
      return null;
    } else {
        $errors = $stmt->errorInfo();
        return $errors[2];
    }
  }

  public function Delete($object) {
    $pdo = Connection::getInstance();
    $stmt = $pdo->Prepare("DELETE FROM Staff WHERE id_staff = ?");
    $stmt->execute(array($object->getId()));
    if($stmt->errorCode() == 0) {
      return null;
    } else {
        $errors = $stmt->errorInfo();
        return $errors[2];
    }
  }

  public function DeleteById($id) {
    $pdo = Connection::getInstance();
    $stmt = $pdo->Prepare("DELETE FROM Staff WHERE id_staff = ?");
    $stmt->execute(array($id));
    if($stmt->errorCode() == 0) {
      return null;
    } else {
        $errors = $stmt->errorInfo();
        return $errors[2];
    }
  }


  public function SelectByID($id) {
    $pdo = Connection::getInstance();
    $stmt = $pdo->Prepare("SELECT * FROM Staff where id_staff = ? LIMIT 1");
    if ($stmt->execute(array($id))) {
      if ($result = $stmt->fetch()) {
        $account = $this->AccountDAO->SelectByID($result['id_account']);
        $role = $this->RoleDAO->SelectByID($result['id_role']);
        $staff = new Staff(
          $result['name'],
          $result['surname'],
          $result['dni'],
          $result['address'],
          $result['phone'],
          $result['salary'],
          $account,
          $role
        );
        $staff->setId($result['id_staff']);
      }
    }
    if($stmt->errorCode() == 0) {
      if (isset($staff)) {
        return $staff;
      } else {
        return null;
      }
    } else {
        $errors = $stmt->errorInfo();
        return $errors[2];
    }
  }

  public function SelectByAccount($object) {
    $pdo = Connection::getInstance();
    $stmt = $pdo->Prepare("SELECT * FROM Staff where id_account = ?  LIMIT 1");
    if ($stmt->execute(array($object->getId()))) {
      if ($result = $stmt->fetch()) {
        $account = $this->AccountDAO->SelectByID($result['id_account']);
        $role = $this->RoleDAO->SelectByID($result['id_role']);
        $staff = new Staff(
          $result['name'],
          $result['surname'],
          $result['dni'],
          $result['address'],
          $result['phone'],
          $result['salary'],
          $account,
          $role
        );
        $staff->setId($result['id_staff']);
      }
    }
    if($stmt->errorCode() == 0) {
      if (isset($staff)) {
        return $staff;
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
    $pdo = Connection::getInstance();
    $stmt = $pdo->Prepare("SELECT * FROM Staff");
    if ($stmt->execute()) {
      while ($result = $stmt->fetch()) {
        $account = $this->AccountDAO->SelectByID($result['id_account']);
        $role = $this->RoleDAO->SelectByID($result['id_role']);
        $staff = new Staff(
          $result['name'],
          $result['surname'],
          $result['dni'],
          $result['address'],
          $result['phone'],
          $result['salary'],
          $account,
          $role
        );
        $staff->setId($result['id_staff']);
        array_push($list, $staff);
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
    $pdo = Connection::getInstance();
    $stmt = $pdo->Prepare("UPDATE Staff SET name = ?, surname = ?, dni = ?, address = ?, phone = ?, salary = ?, id_account = ?, id_role = ? WHERE id_staff = ?");
    $stmt->execute(array(
      $object->getName(),
      $object->getSurname(),
      $object->getDni(),
      $object->getAddress(),
      $object->getPhone(),
      $object->getSalary(),
      $object->getAccount()->getId(),
      $object->getRole()->getId(),
      $object->getId()
    ));
    if($stmt->errorCode() == 0) {
      return null;
    } else {
        $errors = $stmt->errorInfo();
        return $errors[2];
    }
  }
} ?>
