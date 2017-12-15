<?php namespace Controller;

use DAOS\PackagingDAO as PackagingDAO;
use Model\Packaging as Packaging;
use Controller\GestionController as GestionController;

class gestionPackagingController extends GestionController implements IGestion {

  private $packagingDAO;

  public function __construct() {
    self::$roles = array('Admin', 'Empleado');
    try {
      $this->packagingDAO = PackagingDAO::getInstance();
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
      if (getimagesize($_FILES['image']['tmp_name'])) {
        $imageInfo = getimagesize($_FILES['image']['tmp_name']);
        if($imageInfo !== false) {
          if($_FILES['image']['size'] < MAX_IMG_SIZE) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $file)) {
              return basename($file);
            } else {
              $error = 'No se pudo subir el archivo';
            }
          } else {
            $error = 'El archivo es demasiado grande';
          }
        } else {
          $error = 'El archivo no es una imagen';
        }
      } else {
        $error = 'El archivo no es una imagen';
      }
      throw new \Exception("Ocurrio un problema al subir la imagen: ".$error, 1);
    }
  }

  public function Submit() {
    require_once 'AdminViews/SubmitPackaging.php';
  }

  public function SubmitPackaging($description = null, $capacity = null, $factor = null, $image = null) {
    if (isset($description) && isset($capacity) && isset($factor)) {
      if($_FILES)	{
        try {
          $image = $this->UploadImage();
        } catch (\Exception $e) {
          $alert = "yellow";
          $msj = $e->getMessage();
          $this->Alert($msj, $alert);
        }
      }
      $packaging = new Packaging($description, $capacity, $factor, $image);
      try {
        $packaging = $this->packagingDAO->Insert($packaging);
        if (isset($packaging)) {
          $alert = "green";
          $msj = "Envase añadido correctamente: ".$packaging->getDescription();
          $this->Alert($msj, $alert);
        } else {
          // Tiro una Exception, luego la controlo y muestro una alerta
          throw new \Exception("", 1);
        }
      } catch (\Exception $e) {
        $alert = "red";
        $msj = "Ocurrio un problema al agregar el Envase";
        $this->Alert($msj, $alert);
      }
    }
    $this->Submit();
  }

  public function Update($id_packaging = null) {
    try {
      $list = $this->packagingDAO->SelectAll();
    } catch (\Exception $e) {
      $alert = "red";
      $msj = "Ocurrio un problema al traer los Envases";
      $this->Alert($msj, $alert);
      $list = array();
    }
    require_once 'AdminViews/UpdatePackaging.php';
  }

  public function UpdatePackaging($id_packaging = null, $description = null, $capacity = null, $factor = null, $image = null) {
    if (isset($id_packaging) && isset($description) && isset($capacity) && isset($factor)) {
      $packaging = new Packaging($description, $capacity, $factor);
      $packaging->setId($id_packaging);
      try {
          $packaging = $this->packagingDAO->Update($packaging);
          if($_FILES)	{
            if ($_FILES['image']['error'] != UPLOAD_ERR_NO_FILE) {
              try {
                $new_image = $this->UploadImage();
                $packaging->setImage($new_image);
                try {
                  $packaging = $this->packagingDAO->UpdateImage($packaging);
                } catch (\Exception $e) {
                  $alert = "yellow";
                  $msj = "Ocurrio un problema al subir la imagen";
                  $this->Alert();
                }
              } catch (\Exception $e) {
                $alert = "yellow";
                $msj = $e->getMessage();
                $this->Alert($msj, $alert);
              }
            }
          }
          if (isset($packaging)) {
            $alert = "green";
            $msj = "Envase modificado correctamente: ".$packaging->getDescription();
            $this->Alert($msj, $alert);
          } else {
            // Tiro una Exception, luego la controlo y muestro una alerta
            throw new \Exception("", 1);
          }
      } catch (\Exception $e) {
        $alert = "red";
        $msj = "Ocurrio un problema al modificar el Envase";
        $this->Alert($msj, $alert);
      }
    }
    if (isset($packaging)) {
      $id_packaging = $packaging->getId();
    } else {
      $id_packaging = null;
    }
    $this->Update($id_packaging);
  }

  public function Delete() {

    $list = $this->packagingDAO->SelectAll();
    require_once 'AdminViews/DeletePackaging.php';
  }

  public function DeletePackaging($description = null, $id_packaging = null) {
    if (isset($description) && isset($id_packaging)) {
      try {
        if ($this->packagingDAO->DeleteById($id_packaging)) {
          $alert = "green";
          $msj = "Envase eliminado: ".$description." (id ".$id_packaging.")";
          $this->Alert($msj, $alert);
        } else {
          throw new \Exception("", 1);
        }
      } catch (\PDOException $e) {
        $error = $e->errorInfo;
        $alert = "yellow";
        if ($error[1] == '1451') {
          $msj = "No se pudo eliminar, el envase se encuentra asignado a un pedido";
        } else {
          $msj = "Ocurrio un problema con la Base de Datos: error ".$error[1];
        }
        $this->Alert($msj, $alert);
      } catch (\Exception $e) {
        $alert = "yellow";
        $msj = "Ocurrio un problema al eliminar el envase";
        $this->Alert($msj, $alert);
      }
    }
    $this->Delete();
  }
} ?>
