<?php if (isset($alert) && !strcmp($alert, "") == 0) { ?>
  <div class="alert <?= $alert; ?>">
    <?= $msj; ?>
  </div>
<?php } ?>

<form class="form" name="form" action="/gestionSubsidiary/SubmitSubsidiary" method="post" onsubmit="return Validar();">
  <table class="centrar">
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
    <input hidden="hidden" type="number" name="lat" value="0">
    <input hidden="hidden" type="number" name="lon" value="0">
    <tr>
      <td colspan="2"><input type="submit" class="submit" value="Agregar Sucursal"></td>
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
</script>
</body>
</html>
