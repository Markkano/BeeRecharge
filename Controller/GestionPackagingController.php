<?php namespace Controller;

use DAOS\PackagingDAO as PackagingDAO;
use Model\Packaging as Packaging;
use Controller\GestionController as GestionController;

class gestionPackagingController extends GestionController implements IGestion {

  private $packagingDAO;

  public function __construct() {
    self::$roles = array('Admin', 'Empleado');
    $this->packagingDAO = PackagingDAO::getInstance();
    parent::__construct();
  }

  public function Index() {}

  private function UploadImage() {
    if(!file_exists(IMG_PATH)) {
  		mkdir(IMG_PATH);
    }
    if((isset($_FILES['image'])) && ($_FILES['image']['name'] != '')) {
      $file = IMG_PATH . basename($_FILES["image"]["name"]);
      $file = str_replace(' ', '', $file);

			//Obtenemos la extensión del archivo. No sirve para comprobar el veradero tipo del archivo
			$fileExtension = pathinfo($file, PATHINFO_EXTENSION);

			//Genera un array a partir de una verdera imagen. Retorna false si no es una archivo de imagen
			$imageInfo = getimagesize($_FILES['image']['tmp_name']);
			//var_dump($imageInfo);
			if($imageInfo !== false) {
				if($_FILES['image']['size'] < MAX_IMG_SIZE) {
					if (move_uploaded_file($_FILES["image"]["tmp_name"], $file)) {
						return basename($file);
          }
        }
      }
    }
    return null;
  }

  public function Submit($description = null, $capacity = null, $factor = null, $image = null) {
    if (isset($description)) {
      if($_FILES)	{
        $image = $this->UploadImage();
      }
      $packaging = new Packaging($description, $capacity, $factor, $image);
      try {
        $packaging = $this->packagingDAO->Insert($packaging);
        if (isset($packaging)) {
          $alert = "green";
          $msj = "Envase añadido correctamente: ".$packaging->getDescription();
        } else {
          $alert = "yellow";
          $msj = "Ocurrio un problema";
        }
      } catch (\Exception $e) {
        $alert = "yellow";
        $msj = $e->getMessage();
      }
    }
    require_once 'AdminViews/SubmitPackaging.php';
  }

  public function Update($id_packaging = null, $description = null, $capacity = null, $factor = null, $image = null) {
    if (isset($description)) {
      $packaging = new Packaging($description, $capacity, $factor);
      $packaging->setId($id_packaging);
      try {
          $packaging = $this->packagingDAO->Update($packaging);
          if($_FILES)	{
            if ($_FILES['image']['error'] != UPLOAD_ERR_NO_FILE) {
              try {
                $new_image = $this->UploadImage();
                $packaging->setImage($new_image);
                $packaging = $this->packagingDAO->UpdateImage($packaging);
              } catch (\Exception $e) {
                // TODO: Problema al subir el archivo
              }
            }
          }
          if (isset($packaging)) {
            $alert = "green";
            $msj = "Envase modificado correctamente: ".$packaging->getDescription();
          } else {
            $alert = "yellow";
            $msj = "Ocurrio un problema";
          }
      } catch (\Exception $e) {
        $alert = "yellow";
        $msj = $e->getMessage();
      }
    }
    $list = $this->packagingDAO->SelectAll();
    require_once 'AdminViews/UpdatePackaging.php';
  }

  public function Delete($description = null, $id_packaging = null) {
    if (isset($description) && isset($id_packaging)) {
      try {
        if ($this->packagingDAO->DeleteById($id_packaging)) {
          $alert = "green";
          $msj = "Envase eliminado: ".$description." (id ".$id_packaging.")";
        } else {
          $alert = "yellow";
          $msj = "Ocurrio un problema";
        }
      } catch (\Exception $e) {
        $alert = "yellow";
        $msj = $e->getMessage();
      }
    }
    $list = $this->packagingDAO->SelectAll();
    require_once 'AdminViews/DeletePackaging.php';
  }
}
