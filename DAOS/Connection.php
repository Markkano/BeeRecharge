<?php namespace DAOS;

use Config\Config as Config;
use PDO;
use Exception;

class Connection {

  private static $instance = null;
  public static function getInstance() {
    if (is_null(self::$instance)) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  private $pdo;

  protected function __construct() {
    $this->pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
    $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }

  public function Prepare($sql) {
    return $this->pdo->prepare($sql);
  }

  public function LastInsertId() {
    return $this->pdo->lastInsertId();
  }

  public function ErrorInfo() {
    return $this->pdo->errorInfo();
  }

  public function getException(\PDOException $e) {
    $error = $e->errorInfo;
    switch ($error[1]) {
      case '1451':
        throw new Exception("Integrity constraint violation", 1451);
        break;

      case '1062':
        throw new Exception("Registro duplicado", 1062);
        break;

      default:
        throw $e;
        break;
    }
  }
}
?>
