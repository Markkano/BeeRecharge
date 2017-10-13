<?php namespace Controller;

class GestionController {

  public function __construct() {
    require 'AdminViews/GestionLobby.php';
  }

  public function Index() {}

  public function SubmitStaff($object = null) {
    require 'AdminViews/SubmitPackaging.php';
  }

  public function UpdateStaff($object = null) {
    require 'AdminViews/UpdatePackaging.php';
  }

  public function DeleteStaff($object = null) {
    require 'AdminViews/DeletePackaging.php';
  }

  public function SubmitRole($object = null) {
    require 'AdminViews/SubmitPackaging.php';
  }

  public function UpdateRole($object = null) {
    require 'AdminViews/UpdatePackaging.php';
  }

  public function DeleteRole($object = null) {
    require 'AdminViews/DeletePackaging.php';
  }
} ?>
