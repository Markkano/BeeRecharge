<?php if (isset($alert) && !strcmp($alert, "") == 0) { ?>
  <div class="alert <?= $alert; ?>">
    <?= $msj; ?>
  </div>
<?php } ?>

<form class="form" name="form" action="/<?= BASE_URL ?>gestionPackaging/Submit" method="post" onsubmit="return Validar();" enctype="multipart/form-data">
  <table class="centrar">
    <tr>
      <td><h1>Nuevo Envase</h1></td>
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
      <td><label for="image">Imagen</label></td>
    </tr>
    <tr>
      <td colspan="2"><input type="file" name="image" value=""></td>
    </tr>
    <tr>
      <td colspan="2"><input type="submit" class="submit" value="Agregar Envase"></td>
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
</script>
</body>
</html>
