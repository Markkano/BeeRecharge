<?php namespace Model;

class Controller {
  private $id;
  private $description;

  public function __construct($description) {
    $this->setDescription($description);
  }

  public function getId() {
    return $this->id;
  }

  public function setId($value) {
    $this->id = $value;
  }

  public function getDescription() {
    return $this->description;
  }

  public function setDescription($value) {
    $this->description = $value;
  }
} ?>
