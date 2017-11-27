<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Login | DLL</title>
    <link rel="stylesheet" href="/<?= BASE_URL ?>Css/style.css"/>
  </head>
<body>
    <div class="pizarra expandir-fondo">
    	<form action="/<?= BASE_URL ?>SelectOption/Select" method="post">
      	<table class="centrar tabla-login">
      		<tr><td colspan="2"><h1>Seleccione como Desea Ingresar</h1></td></tr>
      			<tr>
      				<td>Ingreso como Cliente</td>
      				<td><input type="radio" name="login" value="Client"></td>
      			</tr>
      			<tr>
      				<td>Ingreso como Staff</td>
      				<td><input type="radio" name="login" value="Staff"></option></td>
      			</tr>
      		<tr>
      			<td colspan="2" align="right"><input type="submit" name="" value='Ingresar' class="btn-login"></td>
      		</tr>      		
		</table>
		</form>
	</div>
</body>
</html>