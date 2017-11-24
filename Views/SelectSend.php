<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Confirmar Envío</title>
    <link rel="styleshet" href="/<?= BASE_URL ?>Css/style.css"/>
  </head>
  <body class="fondo-madera expandir-fondo">
    <div align="center" style="padding-top: 20px;">
			<form name="" action="/<?= BASE_URL ?>Send/SubmitSend" method="post">
				<table class="centrar tabla-register pizarra">
          <tr>
            <td><label for="send">Envío a mi domicilio</label></td>
            <td><input type="radio" name="send" value="0" checked></td>
          </tr>
          <tr>
            <td colspan="2">
              <input type="text" name="client_address" value="<?= $client->getAddress(); ?>" disabled>
            </td>
          </tr>
          <tr>
            <td><label for="send">Envío a otra dirección</label></td>
            <td><input type="radio" name="send" value="1"></td>
          </tr>
          <tr>
            <td colspan="2">
              <input type="text" name="address" value="">
            </td>
          </tr>
					<tr>
						<td><label for="timeRange">Rango Horario de envio</label></td>
          </tr>
          <tr>
						<td colspan="2">
              <select name="timeRange" id="timeRange">
                <?php foreach($time_range_list as $timeRange) { ?>
                <option value="<?= $timeRange->getId();?>"><?=$timeRange->getFrom().' - '.$timeRange->getTo(); ?></option>
                <?php } ?>
              </select>
            </td>
					</tr>
					<tr>
						<td colspan="2"><input type="submit" class="btn-login" value="Confirmar Envío"></td>
					</tr>
				</table>
			</form>
		</div>
  </body>
</html>
