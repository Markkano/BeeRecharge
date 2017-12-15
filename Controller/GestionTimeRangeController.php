<?php namespace Controller;

use DAOS\TimeRangeDAO as TimeRangeDAO;
use Model\TimeRange as TimeRange;
use Controller\GestionController as GestionController;

class GestionTimeRangeController extends GestionController {

	private $timeRangeDAO;

	public function __construct() {
  	self::$roles = array('Admin', 'Empleado');
		try {
			$this->timeRangeDAO = TimeRangeDAO::getInstance();
		} catch (\Exception $e) {
			$alert = "red";
			$msj = "Error: Ocurrio un problema al conectar con la Base de Datos";
		} finally {
			parent::__construct();
			if (isset($msj) && isset($alert)) {
				$this->Alert($msj, $alert);
				die();
			}
		}
	}

	public function Index() {}

	private function getTimeRangeList() {
		try {
      return $this->timeRangeDAO->SelectAll();
    } catch (\Exception $e) {
      $alert = "red";
      $msj = "Ocurrio un problema con la Base de Datos";
      $this->Alert($msj, $alert);
      die();
    }
	}

	public function Submit() {
    require_once 'AdminViews/SubmitTimeRange.php';
	}

	public function SubmitTimeRange($from = null, $to = null) {
		if (isset($from) && isset($to)) {
      $timeRange = new TimeRange($from, $to);
      try {
        $timeRange = $this->timeRangeDAO->Insert($timeRange);
        if (isset($timeRange)) {
          $alert = "green";
          $msj = "Rango Horario añadido correctamente";
					$this->Alert($msj, $alert);
        } else {
					throw new \Exception("", 1);
        }
      } catch (\Exception $e) {
        $alert = "yellow";
        $msj = "Problema al añadir el rango horario";
				$this->Alert($msj, $alert);
      }
    }
		$this->Submit();
	}

	public function Update($id_timeRange = null) {
		$list = $this->getTimeRangeList();
		//requerir la vista correspondiente
		require_once 'AdminViews/UpdateTimeRange.php';
	}

	public function UpdateTimeRange($id_timeRange = null, $from = null, $to = null) {
		if (isset($id_timeRange) && isset($from) && isset($to)) {
      $timeRange = new TimeRange($from, $to);
      $timeRange->setId($id_timeRange);
      try {
          $timeRange = $this->timeRangeDAO->Update($timeRange);
          if (isset($timeRange)) {
            $alert = "green";
            $msj = "Rango horario modificado correctamente";
						$this->Alert($msj, $alert);
						$this->Update($id_timeRange);
	        } else {
						throw new \Exception("", 1);
	        }
      } catch (\Exception $e) {
				$alert = "yellow";
        $msj = "Problema al modificar el rango horario";
				$this->Alert($msj, $alert);
      }
    }
		$this->Update();
	}

	public function Delete($id_timeRange = null) {
    $list = $this->getTimeRangeList();
    require_once 'AdminViews/DeleteTimeRange.php';
	}

	public function DeleteTimeRange($id_timeRange = null) {
		if (isset($id_timeRange)) {
      try {
        if ($this->timeRangeDAO->DeleteById($id_timeRange)) {
          $alert = "green";
          $msj = "Rango Horario eliminado";
				} else {
					throw new \Exception("", 1);
				}
			} catch (\PDOException $e) {
				$error = $e->errorInfo;
				$alert = "yellow";
				if ($error[1] == '1451') {
					$msj = "No se pudo eliminar, el rango horario esta asignado a un envio";
				} else {
					$msj = "Ocurrio un problema con la Base de Datos: error ".$error[1];
				}
				$this->Alert($msj, $alert);
			} catch (\Exception $e) {
				$alert = "yellow";
				$msj = "Problema al eliminar el rango horario";
				$this->Alert($msj, $alert);
	  	}
			$this->Delete();
		}
	}
} ?>
