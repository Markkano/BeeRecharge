<?php namespace Controller;

use DAOS\BeerDAO as BeerDAO;
use Model\Beer as Beer;
use Controller\GestionController as GestionController;
use Config\Config as Config;

class GestionBeerController extends GestionController implements IGestion {

  private $beerDAO;

  public function __construct() {
    self::$roles = array('Admin', 'Empleado', 'Vendedor', 'Flaquito');
    $this->beerDAO = BeerDAO::getInstance();
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
				if(!file_exists($file))	{
					if($_FILES['image']['size'] < MAX_IMG_SIZE) {
						if (move_uploaded_file($_FILES["image"]["tmp_name"], $file)) {
							return basename($_FILES["image"]["name"]);
            }
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
  public function Submit($name = null, $description = null, $price = null, $ibu = null, $srm = null, $graduation = null, $image = null) {
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
    require_once 'AdminViews/SubmitBeer.php';
  }

  public function Update($id_beer = null, $name = null, $description = null, $price = null, $ibu = null, $srm = null, $graduation = null, $image = null) {
    /*
    Si recibo parametros, creo el objeto Beer y actualizo el que tengo en la BD.
    */
    if (isset($name)) {
      $beer = new Beer($name, $description, $price, $ibu, $srm, $graduation, $image);
      $beer->setId($id_beer);
      # Si se envia un archivo del formulario
      if($_FILES)	{
        if ($_FILES['image']['error'] != UPLOAD_ERR_NO_FILE) {
          try {
            $new_image = $this->UploadImage($name);
            $beer->setImage($new_image);
            $this->beerDAO->UpdateImage($beer);
            try {
              $beer = $this->beerDAO->Update($beer);
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
          } catch (\Exception $e) {
            // TODO: Problema al subir el archivo
          }
        }
      }
    }
    try {
      $list = $this->beerDAO->SelectAll();
    } catch (\Exception $e) {
      // TODO: Algun cartel
      echo $e->getMessage();
    }
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
