<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Register | DLL</title>
		<link rel="stylesheet" href="/<?= BASE_URL ?>Css/style.css"/>
	</head>
	<body class="fondo-madera expandir-fondo">
		<a href="/<?= BASE_URL ?>" class="btn-volver">Volver atrás</a>

		<?php if (isset($alert) && !strcmp($alert, "") == 0) { ?>
		  <div class="alert <?= $alert; ?>">
		    <?= $msj; ?>
		  </div>
		<?php } ?>

		<div align="center" style="padding-top: 20px;">
			<div>
				<form name="form" action="/<?= BASE_URL ?>Register/InsertClient" method="post" onsubmit="return Validar();">
					<table class="centrar tabla-register pizarra">
						<tr>
						  <td><label for="username">Nombre de Usuario</label></td>
						  <td><input type="text" name="username" value=""></td>
						</tr>
						<tr>
						  <td><label for="email">Correo Electronico</label></td>
						  <td><input type="email" name="email" value=""></td>
						</tr>
						<tr>
						  <td><label for="password">Contraseña</label></td>
						  <td><input type="password" name="password" value=""></td>
						</tr>
						<tr>
						  <td><label for="name">Nombre</label></td>
						  <td><input type="text" name="name" value=""></td>
						</tr>
						<tr>
						  <td><label for="surname">Apellido</label></td>
						  <td><input type="text" name="surname" value=""></td>
						</tr>
						<tr>
						  <td><label for="dni">DNI</label></td>
						  <td><input type="text" name="dni" value=""></td>
						</tr>
						<tr>
						  <td><label for="address">Direccion</label></td>
						  <td><input type="text" name="address" value=""></td>
						</tr>
						<tr>
						  <td><label for="phone">Teléfono</label></td>
						  <td><input type="tel" name="phone" value=""></td>
						</tr>
						<tr>
						  <td colspan="2"><input type="submit" class="btn-login" value="Registrarse"></td>
						</tr>
					</table>
				</form>
			</div>
		</div>
		<script type="text/javascript">
		function Validar() {
			var ok = true;
		  var form = document.form;

		  if (notText(form.username.value)) ok = false;
			if (notText(form.email.value)) ok = false;
		  if (notText(form.password.value)) ok = false;
			if (notText(form.name.value)) ok = false;
			if (notText(form.surname.value)) ok = false;
			if (notText(form.dni.value)) ok = false;
			if (notText(form.address.value)) ok = false;
			if (notText(form.phone.value)) ok = false;

		  if (!ok) {
		    alert("Compruebe los campos");
		  }
		  return ok;
		}
		</script>
		<script src="/<?= BASE_URL ?>Js/Comprobacion.js" charset="utf-8"></script>
	</body>
</html>
