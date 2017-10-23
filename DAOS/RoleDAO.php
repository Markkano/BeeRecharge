<?php namespace DAOS;
use DAOS\Connection as Connection;
use Model\Role as Role;
class RoleDAO extends SingletonDAO implements IDAO {

  private $pdo;

  public function __construct() {
    $this->pdo = Connection::getInstance();
  }

  public function Insert($object) {
    $stmt = $this->pdo->Prepare("INSERT INTO Roles (rolename, description) values (?,?)");
    $stmt->execute(array(
      $object->getRolename(),
      $object->getDescription()
    ));
    $object->setId($this->pdo->LastInsertId());
    if($stmt->errorCode() == 0) {
      return null;
    } else {
        $errors = $stmt->errorInfo();
        return $errors[2];
    }
  }

  public function Delete($object) {
    $stmt = $this->pdo->Prepare("DELETE FROM Roles WHERE id_role = ?");
    $stmt->execute(array($object->getId()));
    if($stmt->errorCode() == 0) {
      return null;
    } else {
        $errors = $stmt->errorInfo();
        return $errors[2];
    }
  }

  public function DeleteById($id) {
    $stmt = $this->pdo->Prepare("DELETE FROM Roles WHERE id_role = ?");
    $stmt->execute(array($id));
    if($stmt->errorCode() == 0) {
      return null;
    } else {
        $errors = $stmt->errorInfo();
        return $errors[2];
    }
  }

  public function SelectByID($id) {
    $stmt = $this->pdo->Prepare("SELECT * FROM Roles where id_role = ?");
    if ($stmt->execute(array($id))) {
      if ($result = $stmt->fetch()) {
        $role = new Role(
          $result['rolename'],
          $result['description']
        );
        $role->setId($result['id_role']);
      }
    }
    if($stmt->errorCode() == 0) {
      return $role;
    } else {
        $errors = $stmt->errorInfo();
        return $errors[2];
    }
  }

  public function SelectAll() {
    $list = array();
    $stmt = $this->pdo->Prepare("SELECT * FROM Roles");
    if ($stmt->execute()) {
      while ($result = $stmt->fetch()) {
        $role = new Role(
          $result['rolename'],
          $result['description']
        );
        $role->setId($result['id_role']);
        array_push($list, $role);
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
    $stmt = $this->pdo->Prepare("UPDATE Roles SET rolename = ?, description = ? WHERE id_role = ?");
    $stmt->execute(array(
      $object->getRolename(),
      $object->getDescription(),
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
