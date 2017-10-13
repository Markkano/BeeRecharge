<?php namespace Controller;
// TODO eliminar archivo
class packagingGestionController
{
	private $PackagingDAO;

	public function Index()
	{
		$PackagingDAO = PackagingDAO::getInstance();
		$Packs=$PackagingDAO->SelectAll();
		$msj='';
		require_once('../Views/packagingGestion.php');
	}

	public function insertPackaging()
	{
		if(isset($_POST['description']))
		{
			$name=$_POST['capacity'];
			$description=$_POST['description'];

			/*i create an objet with the beer that i'd charged*/
			$pack=new Packaging($description, $capacity);

			/*i look if the object exist in my dao. if exist i return to beermanagement and i show a message with the error*/
			$exist=$PackagingDAO->Select($pack);
			if(!isset($exist))
			{
				$PackagingDAO->Insert($pack);
				$msj='El envase '.$pack->getDescription().' ha sido ingresado correctamente';
			}
			else
			{
				$msj='El envase que desea ingresar ya se encuentra en el sistema.
				Si desea ingresar un cambio en el misma, por favor,
				seleccione Actualizar envase en la barra superior ';
				require_once('../Views/packagingGestion.php');
			}
		}
	}


	public function updatePackaging()
	{
		isset($_POST['capacity']) ? $name=$_POST['capacity'];
		isset($_POST['description']) ? $description=$_POST['description'];


		$pack=new Packaging($description, $capacity);

		$exist=$PackagingDAO->Select($pack);
		if(!isset($exist)){
			$msj='El envase que desea actualizar no se encuentra en el sistema.
				Por favor primero ingrese el envase seleccionando la opcion Cargar envase
				de la ventana superior';
				require_once('../Views/packagingGestion.php');
		}
		else
		{
			$PackagingDAO->Update($pack);
			$msj='El envase '.$pack->getDescription().' ha sido actualizado correctamente';
		}
	}


	public function deletePackaging(){
		isset($_POST['capacity']) ? $name=$_POST['capacity'];
		isset($_POST['description']) ? $description=$_POST['description'];


		$pack=new Packaging($description, $capacity);
		$exist=$PackagingDAO->Select($pack);
		if(isset($exist))
		{
			$PackagingDAO->Delete($pack);
			$msj='El envase '.$description.' se ha borrado de manera correcta.';
			require_once('../Views/packagingGestion.php');
		}
		else
		{
			$msj='Ha surgido algun error y no se ha podido eliminar el envase solicitado';
			require_once('../Views/packagingGestion.php');
		}
	}



}


?>
