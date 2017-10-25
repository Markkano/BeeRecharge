<?php namespace Controller;

use DAOS\TimeRangeDAO as TimeRangeDAO;
use Model\TimeRange as TimeRange;
use Controller\GestionController as GestionController;

class GestionTimeRangeController extends GestionController {

	private $timeRangeDAO;

	public function __construct() {
    	self::$roles = array('Admin');
    	parent::__construct();
  	}
	public function Index() {}

	public function Submit($from = null, $to = null) {
	    if (isset($from) && isset($to)) {
	      $this->timeRangeDAO = TimeRangeDAO::getInstance();
	      $timeRange = new TimeRange($from, $to);
	      $this->timeRangeDAO->Insert($timeRange);
	      $alert = "green";
	      $msj = "Rango Horario añadido correctamente";
	    }
	    //requerira la vista correspondiente
	    require_once 'AdminViews/SubmitTimeRange.php';
	}

	public function Update($id_timeRange = null, $from = null, $to = null) {
		$this->timeRangeDAO = TimeRangeDAO::getInstance();
		/*
		Si recibo parametros, creo el objeto TimeRange y actualizo el que tengo en la BD.
		*/
		if (isset($from) && isset($to)) {
			$timeRange = new TimeRange($from, $to);
			$timeRange->setId($id_timeRange);
			$error = $this->timeRangeDAO->Update($timeRange);
			if (!isset($error)) {
				$alert = "green";
				$msj = "Rango horario modificado correctamente";
			}else{
			$alert = "yellow";
			$msj = "Ocurrio un problema: ".$error;
			}
		}
		$list = $this->timeRangeDAO->SelectAll();
		//requerira la vista correspondiente
		require_once 'AdminViews/UpdateTimeRange.php';
	}

	public function Delete($id_timeRange = null) {
	    $this->timeRangeDAO = TimeRangeDAO::getInstance();
			if (isset($id_timeRange)) {
				$error = $this->timeRangeDAO->DeleteById($id_timeRange);
		    if (!isset($error)) {
		    	$alert = "green";
		        $msj = "Rango Horario eliminado";
		    } else {
		        $alert = "yellow";
		        $msj = "Ocurrio un problema: ".$error;
		    }
			}
	    $list = $this->timeRangeDAO->SelectAll();
	    //requerira la vista correspondiente
	    require_once 'AdminViews/DeleteTimeRange.php';
	}
}

?>
