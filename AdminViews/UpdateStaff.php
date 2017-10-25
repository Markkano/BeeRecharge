<?php if (isset($alert) && !strcmp($alert, "") == 0) { ?>
  <div class="alert <?= $alert; ?>">
    <?= $msj; ?>
  </div>
<?php } ?>
<form class="form" name="form" action="/<?= BASE_URL ?>gestionStaff/Update" method="post" onsubmit="return Validar();">
  <table class="centrar">
    <tr>
      <td><h1>Modificar Staff</h1></td>
    </tr>
    <tr>
      <td colspan="2">
        <select name="staff" id="staff" onchange="Actualizar();">
          <?php foreach($list as $staff) { ?>
          <option value="<?=$staff->getId();?>"><?= $staff->getSurname().", ".$staff->getName();?></option>
          <?php } ?>
        </select>
      </td>
      <tr>
        <td><label for="name">Nombre</label></td>
      </tr>
      <tr>
        <td colspan="2"><input type="text" name="name" value=""></td>
      </tr>
      <tr>
        <td><label for="surname">Apellido</label></td>
      </tr>
      <tr>
        <td colspan="2"><input type="text" name="surname" value=""></td>
      </tr>
      <tr>
        <td><label for="dni">DNI</label></td>
      </tr>
      <tr>
        <td colspan="2"><input type="text" name="dni" value=""></td>
      </tr>
      <tr>
        <td><label for="address">Direccion</label></td>
      </tr>
      <tr>
        <td colspan="2"><input type="text" name="address" value=""></td>
      </tr>
      <tr>
        <td><label for="phone">Telefono</label></td>
      </tr>
      <tr>
        <td colspan="2"><input type="tel" name="phone" value=""></td>
      </tr>
      <tr>
        <td><label for="salary">Sueldo</label></td>
      </tr>
      <tr>
        <td colspan="2"><input type="number" step="0.1" min="0" name="salary" value=""></td>
      </tr>

      <tr>
        <td><label for="id_role">Rol del Staff</label></td>
      </tr>
      <tr>
        <td colspan="2">
          <select name="id_role" id="role">
            <?php foreach($roles as $role) { ?>
            <option value="<?=$role->getId();?>"><?=$role->getRolename();?></option>
            <?php } ?>
          </select>
        </td>
      </tr>

      <tr>
        <td><label for="id_account">Vincular a una cuenta</label></td>
      </tr>
      <tr>
        <td colspan="2">
          <select name="id_account" id="account">
            <?php foreach($accounts as $account) { ?>
            <option value="<?=$account->getId();?>"><?=$account->getUsername();?></option>
            <?php } ?>
          </select>
        </td>
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

  if (notText(form.name.value)) ok = false;
  if (notText(form.surname.value)) ok = false;
  if (notText(form.dni.value)) ok = false;
  if (notText(form.address.value)) ok = false;
  if (notText(form.phone.value)) ok = false;
  if (notNumber(form.salary.value)) ok = false;

  if (!ok) {
    alert("Compruebe los campos");
  }
  return ok;
}

function Mostrar(datos) {
  var staff = JSON.parse(datos);
  var form = document.form;
  form.name.value = staff.name;
  form.surname.value = staff.surname;
  form.dni.value = staff.dni;
  form.address.value = staff.address;
  form.phone.value = staff.phone;
  form.salary.value = staff.salary;
  form.id_role.value = staff.role.id_role;
  form.id_account.value = staff.account.id_account;
}

function Actualizar() {
  var staff = form.staff.options[form.staff.selectedIndex].value;
  Ajax('/<?= BASE_URL ?>Ajax/GetStaff', 'post', 'msj='+staff, function(respuestaAjax) {
    Mostrar(respuestaAjax);
  });
}

window.onload = function() {Actualizar();}
</script>
</body>
</html>
