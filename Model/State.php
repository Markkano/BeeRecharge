<?php namespace Model;

class State {
  private $id_state;
  private $state;

  public function __construct($state) {
    $this->setState($state);
  }

  public function getId() {
    return $this->id_state;
  }

  public function setId($value) {
    $this->id_state = $value;
  }

  public function getState() {
    return $this->state;
  }

  public function setState($value) {
    $this->state = $value;
  }

  public function toJson() {
    return [
			'id_state' => $this->id_state,
			'state' => $this->state
		];
  }
} ?>
