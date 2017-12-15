<?php namespace Model;

class Send {
  private $id_send;
  private $address;
  private $state;
  private $time_range;
  private $date;

  public function __construct($address, $state, $time_range, $date) {
    $this->setAddress($address);
    $this->setState($state);
    $this->setTimeRange($time_range);
    $this->setSendDate($date);
  }

  public function getId() {
    return $this->id_send;
  }

  public function setId($value) {
    $this->id_send = $value;
  }

  public function getAddress() {
    return $this->address;
  }

  public function setAddress($value) {
    $this->address = $value;
  }

  public function getState() {
    return $this->state;
  }

  public function setState($value) {
    $this->state = $value;
  }

  public function getTimeRange() {
    return $this->time_range;
  }

  public function setTimeRange(TimeRange $value) {
    $this->time_range = $value;
  }

  public function getSendDate() {
    return $this->sendDate;
  }

  public function setSendDate($value) {
    if ($value != null) {
			$this->sendDate = $value;
		} else {
			$this->sendDate = date("Y-m-d");
    }
  }
} ?>
