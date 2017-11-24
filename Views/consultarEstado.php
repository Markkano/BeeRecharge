<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title> Lobby  | DLL</title>
    <link rel="stylesheet" href="/<?= BASE_URL ?>Css/style.css"/>
  </head>
<body class="fondo-madera expandir-fondo">
<!---->
	<center><p class="tabla-envases pizarra expandir-fondo" style="font-family: 'Old Bookshop'"> 
	Selecciona el rango de fechas en las que desea consultar estados</p></center>

	<!--
	<?php/* if(isset($msj)){?>
	<center><p class="tabla-envases pizarra expandir-fondo" style="font-family: 'Old Bookshop'"> 
	<?=$msj;?>
	</p></center>
	<?php}*/?>
	-->

	<form action="/<?= BASE_URL ?>consultarEstado/consultar" method="post">
		<table class="tabla-envases pizarra expandir-fondo" align="center" style="font-family: 'Old Bookshop'">
			<tr>
				<td>DESDE:</td>
				<td><input type="date" name="desde" required></td>
			</tr>
				<tr>
				<td>HASTA:</td>
				<td><input type="date" name="hasta" required></td>
			</tr>
			<tr><td colspan="2" align="right">
				<input type="submit" class="submit" value="consultar"  name="consultar">
			</td></tr>
		</table>
	</form>
	

	<!--se comparará la variable booleana y se dara inicio con el formulario de muestra de los pedidos-->
	<?php if(isset($orderList)){?>
	<table class="tabla-envases pizarra expandir-fondo" align="center" style="font-family: 'Old Bookshop'">
		<tr>
			<td>Cliente: </td>
			<td><?=$client->getName();?></td>
		</tr>
		<tr>
			<td>DNI:</td>
			<td><?=$client->getDNI();?></td>
		</tr>
		<tr>
			<td> FECHA </td>
			<td> DETALLE </td>
			<td> IMPORTE </td>
			<td> ESTADO </td>
		</tr>
		<?php if(isset($msj))echo'<tr><td colspan=2 align="center">'.$msj.'</td></tr>';?>
		<?php foreach ($orderList as $ordenes){ ?>
			<tr>
				<td><?= $ordenes->getOrderDate(); ?></td>
				<td><a href="/<?= BASE_URL ?>consultarEstado/verDetalle/<?=$ordenes->getOrderNumber();?>" class="btn-volver">Ver Detalle</a></td>
				<td><?= $ordenes->getTotal(); ?></td>
				<td><?= $ordenes->getState()->getState();?></td>
			</tr>
		<?php } ?>		
	</table>
	<?php } ?>
</body>
</html>