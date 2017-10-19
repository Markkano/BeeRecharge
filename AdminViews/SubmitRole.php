<?php if (isset($alert) && !strcmp($alert, "") == 0) { ?>
  <div class="alert <?= $alert; ?>">
    <?= $msj; ?>
  </div>
<?php } ?>

<form class="form" name="form" action="/gestionRole/SubmitRole" method="post" onsubmit="return Validar();">
  <table class="centrar">
    <tr>
      <td><h1>Nuevo Rol</h1></td>
    </tr>
    <tr>
      <td><label for="rolename">Rol</label></td>
    </tr>
    <tr>
      <td colspan="2"><input type="text" name="rolename" value=""></td>
    </tr>
    <tr>
      <td><label for="description">Descripción</label></td>
    </tr>
    <tr>
      <td colspan="2"><input type="text" name="description" value=""></td>
    </tr>
    <tr>
      <td colspan="2"><input type="submit" class="submit" value="Agregar Rol"></td>
    </tr>
  </table>
</form>

<script type="text/javascript">
function Validar() {
  var ok = true;
  var form = document.form;

  if (notText(form.rolename.value)) ok = false;
  if (notText(form.description.value)) ok = false;

  if (!ok) {
    alert("Compruebe los campos");
  }
  return ok;
}
</script>
</body>
</html>
