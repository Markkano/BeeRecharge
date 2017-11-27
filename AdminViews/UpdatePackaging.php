<?php if (isset($alert) && !strcmp($alert, "") == 0) { ?>
  <div class="alert <?= $alert; ?>">
    <?= $msj; ?>
  </div>
<?php } ?>
<form class="form" name="form" action="/<?= BASE_URL ?>gestionPackaging/Update" method="post" onsubmit="return Validar();" enctype="multipart/form-data">
  <table class="centrar">
    <tr>
      <td><h1>Modificar Envase</h1></td>
    </tr>
    <tr>
      <td colspan="2">
        <select name="id" id="packaging" onchange="Actualizar()">
          <?php foreach($list as $beer) { ?>
          <option value="<?=$beer->getId();?>"><?=$beer->getDescription();?></option>
          <?php } ?>
        </select>
      </td>
    </tr>
    <tr>
      <td><label for="description">Descripción</label></td>
    </tr>
    <tr>
      <td colspan="2"><input type="text" name="description" value=""></td>
    </tr>
    <tr>
      <td><label for="capacity">Capacidad</label></td>
    </tr>
    <tr>
      <td colspan="2"><input type="number" step="0.01" min="0" name="capacity" value=""></td>
    </tr>
    <tr>
      <td><label for="factor">Factor de descuento</label></td>
    </tr>
    <tr>
      <td colspan="2"><input type="number" step="0.01" min="0" name="factor" value="1.0"></td>
    </tr>
    <tr>
      <td colspan="2" id="img"></td>
    </tr>
    <tr>
      <td colspan="2"><input type="file" name="image" value=""></td>
    </tr>
    <tr>
    <tr>
      <td colspan="2"><input type="submit" class="submit" value="Guardar cambios"></td>
    </tr>
  </table>
</form>

<script type="text/javascript">
function Validar() {
  var ok = true;
  var form = document.form;

  if (notText(form.description.value)) ok = false;
  if (notNumber(form.capacity.value)) ok = false;
  if (notNumber(form.factor.value)) ok = false;

  if (!ok) {
    alert("Compruebe los campos");
  }
  return ok;
}

function Mostrar(datos) {
  var packaging = JSON.parse(datos);
  var form = document.form;
  form.description.value = packaging.description;
  form.capacity.value = packaging.capacity;
  form.factor.value = packaging.factor;

  if (packaging.image != "" && packaging.image != null) {
    var img = "/<?= BASE_URL.IMG_PATH ?>"+packaging.image;
    document.getElementById('img').innerHTML = "<img src="+img+">";
  } else {
    document.getElementById('img').innerHTML = "";
  }
}

function Actualizar() {
  var packaging = form.packaging.options[form.packaging.selectedIndex].value;
  Ajax('/<?= BASE_URL ?>Ajax/GetPackaging', 'post', 'msj='+packaging, function(respuestaAjax) {
    Mostrar(respuestaAjax);
  });
}

window.onload = function() {Actualizar();}
</script>
</body>
</html>
