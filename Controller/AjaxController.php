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

use DAOS\TimeRangeDAO as TimeRangeDAO;
use Model\TimeRange as TimeRange;

use DAOS\StateDAO as StateDAO;
use Model\State as State;

class AjaxController {

  private $beerDAO;
  private $packagingDAO;
  private $subsidiary;
  private $staffDAO;
  private $roleDAO;
  private $timeRangeDAO;
  private $stateDAO;

  public function GetBeer($id) {
    $this->beerDAO = BeerDAO::getInstance();
    $beer = $this->beerDAO->SelectByID($id);
    echo json_encode($beer->toJson());
  }

  public function GetPackaging($id) {
    $this->packagingDAO = PackagingDAO::getInstance();
    $packaging = $this->packagingDAO->SelectByID($id);
    echo json_encode($packaging->toJson());
  }

  public function GetSubsidiary($id) {
    $this->subsidiaryDAO = SubsidiaryDAO::getInstance();
    $subsidiary = $this->subsidiaryDAO->SelectByID($id);
    echo json_encode($subsidiary->toJson());
  }

  public function GetStaff($id) {
    $this->staffDAO = StaffDAO::getInstance();
    $staff = $this->staffDAO->SelectByID($id);
    echo json_encode($staff->toJson());
  }

  public function GetRole($id) {
    $this->roleDAO = RoleDAO::getInstance();
    $role = $this->roleDAO->SelectByID($id);
    echo json_encode($role->toJson());
  }

  public function GetTimeRange($id) {
    $this->timeRangeDAO = TimeRangeDAO::getInstance();
    $timeRange = $this->timeRangeDAO->SelectByID($id);
    echo json_encode($timeRange->toJson());
  }

  public function GetState($id) {
    $this->stateDAO = StateDAO::getInstance();
    $state = $this->stateDAO->SelectByID($id);
    echo json_encode($state->toJson());
  }
} ?>
