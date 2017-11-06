<?php namespace Controller;

use DAOS\TimeRangeDAO as TimeRangeDAO;
use Model\TimeRange as TimeRange;
use Controller\GestionController as GestionController;

class GestionTimeRangeController extends GestionController {

	private $timeRangeDAO;

	public function __construct() {
  	self::$roles = array('Admin', 'Empleado');
		$this->timeRangeDAO = TimeRangeDAO::getInstance();
  	parent::__construct();
	}

	public function Index() {}

	public function Submit($from = null, $to = null) {
		if (isset($from) && isset($to)) {
      $timeRange = new TimeRange($from, $to);
      try {
        $timeRange = $this->timeRangeDAO->Insert($timeRange);
        if (isset($timeRange)) {
          $alert = "green";
          $msj = "Rango Horario añadido correctamente";
        } else {
          $alert = "yellow";
          $msj = "Ocurrio un problema";
        }
      } catch (\Exception $e) {
        $alert = "yellow";
        $msj = $e->getMessage();
      }
    }
    require_once 'AdminViews/SubmitTimeRange.php';
	}

	public function Update($id_timeRange = null, $from = null, $to = null) {
		if (isset($id_timeRange) && isset($from) && isset($to)) {
      $timeRange = new TimeRange($from, $to);
      $timeRange->setId($id_timeRange);
      try {
          $timeRange = $this->timeRangeDAO->Update($timeRange);
          if (isset($timeRange)) {
            $alert = "green";
            $msj = "Rango horario modificado correctamente";
          } else {
            $alert = "yellow";
            $msj = "Ocurrio un problema";
          }
      } catch (\Exception $e) {
        $alert = "yellow";
        $msj = $e->getMessage();
      }
    }
		$list = $this->timeRangeDAO->SelectAll();
		//requerir la vista correspondiente
		require_once 'AdminViews/UpdateTimeRange.php';
	}

	public function Delete($id_timeRange = null) {
		if (isset($id_timeRange)) {
      try {
        if ($this->timeRangeDAO->DeleteById($id_timeRange)) {
          $alert = "green";
          $msj = "Rango Horario eliminado";
        } else {
          $alert = "yellow";
          $msj = "Ocurrio un problema";
        }
      } catch (\Exception $e) {
        $alert = "yellow";
        $msj = $e->getMessage();
      }
  	}
    $list = $this->timeRangeDAO->SelectAll();
    //requerira la vista correspondiente
    require_once 'AdminViews/DeleteTimeRange.php';
	}
}

?>
