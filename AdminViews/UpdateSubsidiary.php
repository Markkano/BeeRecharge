<?php if (isset($alert) && !strcmp($alert, "") == 0) { ?>
  <div class="alert <?= $alert; ?>">
    <?= $msj; ?>
  </div>
<?php } ?>

<form class="form" name="form" action="/<?= BASE_URL ?>gestionSubsidiary/Update" method="post" onsubmit="return Validar();">
  <table class="centrar">
    <tr>
      <td><h1>Modificar Sucursal</h1></td>
    </tr>
    <tr>
      <td colspan="2">
        <select name="id" id="subsidiary" onchange="Actualizar()">
          <?php foreach($list as $subsidiary) { ?>
          <option value="<?=$subsidiary->getId();?>"><?=$subsidiary->getAddress();?></option>
          <?php } ?>
        </select>
      </td>
    </tr>
    <tr>
      <td><label for="address">Dirección</label></td>
    </tr>
    <tr>
      <td colspan="2"><input type="text" name="address" value=""></td>
    </tr>
    </tr>
    <tr>
      <td><label for="phone">Telefono</label></td>
    </tr>
    <tr>
      <td colspan="2"><input type="tel" name="phone" value=""></td>
    </tr>
    <input hidden="hidden" type="text" name="lat" value="0">
    <input hidden="hidden" type="text" name="lon" value="0">
    <tr>
      <td colspan="2"><input type="submit" class="submit" value="Guardar cambios"></td>
    </tr>
  </table>
</form>

<script type="text/javascript">
function Validar() {
  var ok = true;
  var form = document.form;

  if (notText(form.address.value)) ok = false;
  if (notText(form.phone.value)) ok = false;

  if (!ok) {
    alert("Compruebe los campos");
  }
  return ok;
}

function Mostrar(datos) {
  var subsidiary = JSON.parse(datos);
  var form = document.form;
  form.address.value = subsidiary.address;
  form.phone.value = subsidiary.phone;
  form.lat.value = subsidiary.lat;
  form.lon.value = subsidiary.lon;
}

function Actualizar() {
  var subsidiary = form.subsidiary.options[form.subsidiary.selectedIndex].value;
  Ajax('/<?= BASE_URL ?>Ajax/GetSubsidiary', 'post', 'msj='+subsidiary, function(respuestaAjax) {
    Mostrar(respuestaAjax);
  });
}

window.onload = function() {Actualizar();}
</script>
</body>
</html>
