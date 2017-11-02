<?php namespace DAOS;
use Config\Config as Config;
use PDO;
class Connection {

  private static $instance = null;
  public static function getInstance() {
    if (is_null(self::$instance)) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  private $pdo;

  private function __construct() {
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
}
?>
