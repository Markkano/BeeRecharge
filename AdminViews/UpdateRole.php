<?php if (isset($alert) && !strcmp($alert, "") == 0) { ?>
  <div class="alert <?= $alert; ?>">
    <?= $msj; ?>
  </div>
<?php } ?>
<form class="form" name="form" action="/<?= BASE_URL ?>gestionRole/Update" method="post" onsubmit="return Validar();">
  <table class="centrar">
    <tr>
      <td><h1>Modificar Rol</h1></td>
    </tr>
    <tr>
      <td colspan="2">
        <select name="id" id="role" onchange="Actualizar()">
          <?php foreach($list as $role) { ?>
          <option value="<?=$role->getId();?>"><?=$role->getRolename();?></option>
          <?php } ?>
        </select>
      </td>
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
      <td colspan="2"><input type="submit" class="submit" value="Guardar cambios"></td>
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

function Mostrar(datos) {
  var role = JSON.parse(datos);
  var form = document.form;
  form.rolename.value = role.rolename;
  form.description.value = role.description;
}

function Actualizar() {
  var beer = form.role.options[form.role.selectedIndex].value;
  Ajax('/<?= BASE_URL ?>Ajax/GetRole', 'post', 'msj='+beer, function(respuestaAjax) {
    Mostrar(respuestaAjax);
  });
}

window.onload = function() {Actualizar();}
</script>
</body>
</html>
