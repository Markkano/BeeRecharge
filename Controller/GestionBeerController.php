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
    $this->beerDAO = BeerDAO::getInstance();
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

			//Obtenemos la extensión del archivo. No sirve para comprobar el veradero tipo del archivo
			$fileExtension = pathinfo($file, PATHINFO_EXTENSION);

			//Genera un array a partir de una verdera imagen. Retorna false si no es una archivo de imagen
			$imageInfo = getimagesize($_FILES['image']['tmp_name']);
			//var_dump($imageInfo);
			if($imageInfo !== false) {
				if($_FILES['image']['size'] < MAX_IMG_SIZE) {
					if (move_uploaded_file($_FILES["image"]["tmp_name"], $file)) {
						return basename($_FILES["image"]["name"]);
          }
        }
      }
    }
    return null;
  }

  /*
  La primera vez que entra llama a la vista.
  Cuando se envia el form desde la vista, la funcion recibe la nueva Cerveza
  y aplica la logica necesaria
  */
  public function Submit($name = null, $description = null, $price = null, $ibu = null, $srm = null, $graduation = null, $packagings = null, $image = null) {
    /*
    Si recibo parametros, creo el objeto Beer y lo inserto en la BD.
    */
    if (isset($name)) {
      /*
      Si se envio algun archivo lo subo al servidor y le asigno el nombre a la cerveza
      */
      if($_FILES)	{
        $image = $this->UploadImage($name);
      }
      $beer = new Beer($name, $description, $price, $ibu, $srm, $graduation, $image);
      if (isset($packagings) && is_array($packagings)) {
        try {
          foreach ($packagings as $key) {
            $pack = $this->packagingDAO->SelectByID($key);
            if (isset($pack)) {
              $beer->AddPackaging($pack);
            }
          }
        } catch (\Exception $e) {
          //Problema al asignar packagings
        }
      }
      try {
        $beer = $this->beerDAO->Insert($beer);
        if (isset($beer)) {
          $alert = "green";
          $msj = "Cerveza añadida correctamente: ".$beer->getName();
        } else {
          $alert = "yellow";
          $msj = "Ocurrio un problema";
        }
      } catch (\Exception $e) {
        $alert = "yellow";
        $msj = $e->getMessage();
      }
    }
    $packagings_list = $this->packagingDAO->SelectAll();
    require_once 'AdminViews/SubmitBeer.php';
  }

  public function Update($id_beer = null, $name = null, $description = null, $price = null, $ibu = null, $srm = null, $graduation = null, $packagings = null, $image = null) {
    /*
    Si recibo parametros, creo el objeto Beer y actualizo el que tengo en la BD.
    */
    echo $image;
    if (isset($name)) {
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
        }
        $beer = $this->beerDAO->Update($beer);
        # Si se envia un archivo del formulario
        if($_FILES)	{
          if ($_FILES['image']['error'] != UPLOAD_ERR_NO_FILE) {
            try {
              $new_image = $this->UploadImage($name);
              $beer->setImage($new_image);
              print_r($beer->toJson());
              $beer = $this->beerDAO->UpdateImage($beer);
            } catch (\Exception $e) {
              // TODO: Problema al subir el archivo
            }
          }
        }
        if (isset($beer)) {
          $alert = "green";
          $msj = "Cerveza modificada correctamente: ".$beer->getName();
        } else {
          $alert = "yellow";
          $msj = "Ocurrio un problema";
        }
      } catch (\Exception $e) {
        $alert = "yellow";
        $msj = $e->getMessage();
      }
    }
    $list = $this->beerDAO->SelectAll();
    $packagings_list = $this->packagingDAO->SelectAll();
    require_once 'AdminViews/UpdateBeer.php';
  }

  public function Delete($name = null, $id_beer = null) {
    /*
    Si recibo parametros, elimino el que tengo en la BD.
    */
    if (isset($name)) {
      try {
        if ($this->beerDAO->DeleteById($id_beer)) {
          $alert = "green";
          $msj = "Cerveza eliminada: ".$name." (id ".$id_beer.")";
        } else {
          $alert = "yellow";
          $msj = "Ocurrio un problema";
        }
      } catch (\Exception $e) {
        $alert = "yellow";
        $msj = $e->getMessage();
      }
    }
    $list = $this->beerDAO->SelectAll();
    require_once 'AdminViews/DeleteBeer.php';
  }
} ?>
