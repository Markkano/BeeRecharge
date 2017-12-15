<?php namespace Controller;

use DAOS\BeerDAO as BeerDAO;
use Model\Beer as Beer;
use DAOS\PackagingDAO as PackagingDAO;
use Model\Packaging as Packaging;
use Controller\GestionController as GestionController;
use Config\Config as Config;

class GestionBeerController extends GestionController implements IGestion {

  private $beerDAO;
  private $packagingDAO;

  public function __construct() {
    self::$roles = array('Admin', 'Empleado', 'Vendedor', 'Flaquito');
    try {
      $this->beerDAO = BeerDAO::getInstance();
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
    try {
      $packagings_list = $this->packagingDAO->SelectAll();
    } catch (\Exception $e) {
      $packagings_list = array();
    }
    require_once 'AdminViews/SubmitBeer.php';
  }

  public function SubmitBeer($name = null, $description = null, $price = null, $ibu = null, $srm = null, $graduation = null, $packagings = null, $image = null) {
    /*
    Si recibo parametros, creo el objeto Beer y lo inserto en la BD.
    */
    if (isset($name) && isset($name) && isset($description) && isset($price) && isset($ibu) && isset($srm) && isset($graduation)) {
      /*
      Si se envio algun archivo lo subo al servidor y guardo el nombre del archivo
      para guardaro en la Cerveza.
      */
      if($_FILES)	{
        try {
          $image = $this->UploadImage();
        } catch (\Exception $e) {
          $alert = "yellow";
          $msj = $e->getMessage();
          $this->Alert($msj, $alert);
        }
      }
      // Creo el objeto Beer
      $beer = new Beer($name, $description, $price, $ibu, $srm, $graduation, $image);
      // Cargo los Packagings
      if (isset($packagings) && is_array($packagings)) {
        // Si no esta vacio el arreglo
        if (!empty($packagings)) {
          try {
            foreach ($packagings as $key) {
              $pack = $this->packagingDAO->SelectByID($key);
              if (isset($pack)) {
                $beer->AddPackaging($pack);
              }
            }
          } catch (\Exception $e) {
            $alert = "yellow";
            $msj = "Problema al asignar envases";
            $this->Alert($msj, $alert);
          }
        }
      } else {
        $alert = "yellow";
        $msj = "Atencion: no se han seleccionado envases. Si no se ingresan envases, la cerveza no estara a la venta";
        $this->Alert($msj, $alert);
      }
      try {
        //Inserto en la DB
        $beer = $this->beerDAO->Insert($beer);
        if (isset($beer)) {
          $alert = "green";
          $msj = "Cerveza añadida correctamente: ".$beer->getName();
          $this->Alert($msj, $alert);
        } else {
          // Tiro una Exception, luego la controlo y muestro una alerta
          throw new \Exception("", 1);
        }
      } catch (\PDOException $e) {
        $error = $e->errorInfo;
        $alert = "yellow";
        if ($error[1] == '1062') { //Entrada duplicada
          $msj = "Ya existe la cerveza ".$name.". Por favor ingrese un nombre diferente.";
        } else {
          $msj = "Ocurrio un problema con la Base de Datos: error ".$error[1];
        }
        $this->Alert($msj, $alert);
        /*
        TODO: Volver al formulario con los campos cargados
          evita que el usuario ingrese los datos otra vez
        */
      } catch (\Exception $e) {
        $alert = "red";
        $msj = "Ocurrio un problema al agregar la Cerveza";
        $this->Alert($msj, $alert);
      }
    }
    //Vuelvo al formulario
    $this->Submit();
  }

  public function Update($id_beer = null) {
    try {
      $packagings_list = $this->packagingDAO->SelectAll();
    } catch (\Exception $e) {
      $packagings_list = array();
    }
    try {
      $list = $this->beerDAO->SelectAll();
    } catch (\Exception $e) {
      $alert = "red";
      $msj = "Ocurrio un problema al traer las Cervezas";
      $this->Alert($msj, $alert);
      $list = array();
    }
    require_once 'AdminViews/UpdateBeer.php';
  }

  public function UpdateBeer($id_beer = null, $name = null, $description = null, $price = null, $ibu = null, $srm = null, $graduation = null, $packagings = null, $image = null) {
    if (isset($name) && isset($name) && isset($description) && isset($price) && isset($ibu) && isset($srm) && isset($graduation)) {
      $beer = new Beer($name, $description, $price, $ibu, $srm, $graduation, $image);
      $beer->setId($id_beer);
      try {
        if (isset($packagings) && is_array($packagings)) {
          $beer->setPackagings(array());
          foreach ($packagings as $key) {
            $pack = $this->packagingDAO->SelectByID($key);
            if (isset($pack)) {
              $beer->AddPackaging($pack);
            }
          }
        } else {
          $alert = "yellow";
          $msj = "Atencion: no se han seleccionado envases. Si no se ingresan envases, la cerveza no estara a la venta";
          $this->Alert($msj, $alert);
        }
        $beer = $this->beerDAO->Update($beer);
        # Si se envia un archivo del formulario
        if($_FILES)	{
          if ($_FILES['image']['error'] != UPLOAD_ERR_NO_FILE) {
            try {
              $new_image = $this->UploadImage();
              $beer->setImage($new_image);
              try {
                $beer = $this->beerDAO->UpdateImage($beer);
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
        if (isset($beer)) {
          $alert = "green";
          $msj = "Cerveza modificada correctamente: ".$beer->getName();
          $this->Alert($msj, $alert);
        } else {
          throw new \Exception("", 1);
        }
      } catch (\PDOException $e) {
        $error = $e->errorInfo;
        $alert = "yellow";
        if ($error[1] == '1062') { //Entrada duplicada
          $msj = "Ya existe la cerveza ".$name.". Por favor ingrese un nombre diferente.";
        } else {
          $msj = "Ocurrio un problema con la Base de Datos: error ".$error[1];
        }
        $this->Alert($msj, $alert);
        /*
        TODO: Volver al formulario con los campos cargados
          evita que el usuario ingrese los datos otra vez
        */
      } catch (\Exception $e) {
        $alert = "yellow";
        $msj = "Ocurrio un problema al modificar la Cerveza";
        $this->Alert($msj, $alert);
      }
    }
    if (isset($beer)) {
      $id_beer = $beer->getId();
    } else {
      $id_beer = null;
    }
    $this->Update($id_beer);
  }

  public function Delete() {
    try {
      $list = $this->beerDAO->SelectAll();
    } catch (\Exception $e) {
      $alert = "red";
      $msj = "Ocurrio un problema al traer las Cervezas";
      $this->Alert($msj, $alert);
      $list = array();
    }
    require_once 'AdminViews/DeleteBeer.php';
  }

  public function DeleteBeer($name = null, $id_beer = null) {
    /*
    Si recibo parametros, elimino el que tengo en la BD.
    */
    if (isset($name) && isset($id_beer)) {
      try {
        if ($this->beerDAO->DeleteById($id_beer)) {
          $alert = "green";
          $msj = "Cerveza eliminada: ".$name." (id ".$id_beer.")";
          $this->Alert($msj, $alert);
        } else {
          throw new \Exception("", 1);
        }
      } catch (\PDOException $e) {
        $error = $e->errorInfo;
        $alert = "yellow";
        if ($error[1] == '1451') {
          $msj = "No se pudo eliminar, la cerveza se encuentra asignada a un pedido";
        } else {
          $msj = "Ocurrio un problema con la Base de Datos: error ".$error[1];
        }
        $this->Alert($msj, $alert);
      } catch (\Exception $e) {
        $alert = "yellow";
        $msj = "Ocurrio un problema al eliminar la cerveza";
        $this->Alert($msj, $alert);
      }
    }
    $this->Delete();
  }
} ?>
