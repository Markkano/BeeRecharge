<?php namespace Controller;
use DAOS\BeerDAO as BeerDAO;
use Model\Beer as Beer;

use DAOS\PackagingDAO as PackagingDAO;
use Model\Packaging as Packaging;

use DAOS\SubsidiaryDAO as SubsidiaryDAO;
use Model\Subsidiary as Subsidiary;

use DAOS\StaffDAO as StaffDAO;
use Model\Staff as Staff;

use DAOS\RoleDAO as RoleDAO;
use Model\Role as Role;

class AjaxController {

  private $beerDAO;
  private $packagingDAO;
  private $subsidiary;
  private $staffDAO;
  private $roleDAO;

  public function GetBeer($id) {
    $this->beerDAO = new BeerDAO();
    $beer = $this->beerDAO->SelectByID($id);
    echo json_encode($beer->toJson());
  }

  public function GetPackaging($id) {
    $this->packagingDAO = new PackagingDAO();
    $packaging = $this->packagingDAO->SelectByID($id);
    echo json_encode($packaging->toJson());
  }

  public function GetSubsidiary($id) {
    $this->subsidiaryDAO = new SubsidiaryDAO();
    $subsidiary = $this->subsidiaryDAO->SelectByID($id);
    echo json_encode($subsidiary->toJson());
  }

  public function GetStaff($id) {
    $this->staffDAO = new StaffDAO();
    $staff = $this->staffDAO->SelectByID($id);
    echo json_encode($staff->toJson());
  }

  public function GetRole($id) {
    $this->roleDAO = new RoleDAO();
    $role = $this->roleDAO->SelectByID($id);
    echo json_encode($role->toJson());
  }
} ?>
