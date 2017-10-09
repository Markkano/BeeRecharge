<?php namespace DAOS;
interface IDAO {
  public function Insert($object);
  public function Delete($object);
  public function SelectByID($id);
  public function SelectAll();
  public function Update($object);
} ?>
