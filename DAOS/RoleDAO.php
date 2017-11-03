<?php namespace DAOS;
use DAOS\Connection as Connection;
use Model\Role as Role;
class RoleDAO extends SingletonDAO implements IDAO {

  private $pdo;
  protected $table = 'Roles';

  protected function __construct() {
    $this->pdo = Connection::getInstance();
  }

  public function Insert($object) {
    try {

    } catch (\PDOException $e) {
      throw $e;
    }
    $stmt = $this->pdo->Prepare("INSERT INTO ".$this->table." (rolename, description) values (?,?)");
    $stmt->execute(array(
      $object->getRolename(),
      $object->getDescription()
    ));
    $object->setId($this->pdo->LastInsertId());
    return $object;
  }

  public function Delete($object) {
    try {
      $stmt = $this->pdo->Prepare("DELETE FROM ".$this->table." WHERE id_role = ?");
      $stmt->execute(array($object->getId()));
    } catch (\PDOException $e) {
      throw $e;
    }
  }

  public function DeleteById($id) {
    try {
      $stmt = $this->pdo->Prepare("DELETE FROM ".$this->table." WHERE id_role = ?");
      $stmt->execute(array($id));
    } catch (\PDOException $e) {
      throw $e;
    }
  }

  public function SelectByID($id) {
    try {
      $stmt = $this->pdo->Prepare("SELECT * FROM ".$this->table." where id_role = ?");
      if ($stmt->execute(array($id))) {
        if ($result = $stmt->fetch()) {
          $role = new Role(
            $result['rolename'],
            $result['description']
          );
          $role->setId($result['id_role']);
          return $role;
        }
      }
    } catch (\PDOException $e) {
      throw $e;
    }
  }

  public function SelectAll() {
    try {
      $list = array();
      $stmt = $this->pdo->Prepare("SELECT * FROM ".$this->table."");
      if ($stmt->execute()) {
        while ($result = $stmt->fetch()) {
          $role = new Role(
            $result['rolename'],
            $result['description']
          );
          $role->setId($result['id_role']);
          array_push($list, $role);
        }
        return $list;
      }
    } catch (\PDOException $e) {
      throw $e;
    }
  }

  public function Update($object) {
    try {
      $stmt = $this->pdo->Prepare("UPDATE ".$this->table." SET rolename = ?, description = ? WHERE id_role = ?");
      $stmt->execute(array(
        $object->getRolename(),
        $object->getDescription(),
        $object->getId()
      ));
    } catch (\PDOException $e) {
      throw $e;
    }
  }
} ?>
