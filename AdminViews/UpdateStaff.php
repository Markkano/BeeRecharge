<style media="screen">
  .oculto {
    visibility: hidden;
    position: fixed;
  }

  .oculto tr {
    visibility: visible;
    position: inherit;
  }
</style>
<form class="form" name="form" action="/<?= BASE_URL ?>gestionStaff/UpdateStaff" method="post" onsubmit="return Validar();">
  <table class="centrar">
    <tr>
      <td><h1>Modificar Staff</h1></td>
    </tr>
    <tr>
      <td colspan="2">
        <select name="staff" id="staff" onchange="Actualizar();">
          <?php foreach($list as $staff) { ?>
          <option <?php if (isset($id_staff) && ($id_staff == $staff->getId())) { echo "selected"; } ?>
            value="<?=$staff->getId();?>"><?= $staff->getSurname().", ".$staff->getName();?></option>
          <?php } ?>
        </select>
      </td>
      <tr>
        <td><label for="name">Nombre</label></td>
      </tr>
      <tr>
        <td colspan="2"><input type="text" name="name" value="<?php if(isset($name)) { echo $name; } ?>"></td>
      </tr>
      <tr>
        <td><label for="surname">Apellido</label></td>
      </tr>
      <tr>
        <td colspan="2"><input type="text" name="surname" value="<?php if(isset($name)) { echo $name; } ?>"></td>
      </tr>
      <tr>
        <td><label for="dni">DNI</label></td>
      </tr>
      <tr>
        <td colspan="2"><input type="text" name="dni" value="<?php if(isset($name)) { echo $name; } ?>"></td>
      </tr>
      <tr>
        <td><label for="address">Direccion</label></td>
      </tr>
      <tr>
        <td colspan="2"><input type="text" name="address" value="<?php if(isset($name)) { echo $name; } ?>"></td>
      </tr>
      <tr>
        <td><label for="phone">Telefono</label></td>
      </tr>
      <tr>
        <td colspan="2"><input type="tel" name="phone" value="<?php if(isset($name)) { echo $name; } ?>"></td>
      </tr>
      <tr>
        <td><label for="salary">Sueldo</label></td>
      </tr>
      <tr>
        <td colspan="2"><input type="number" step="0.1" min="0" name="salary" value="<?php if(isset($name)) { echo $name; } ?>"></td>
      </tr>

      <tr>
        <td><label for="id_role">Rol del Staff</label></td>
      </tr>
      <tr>
        <td colspan="2">
          <select name="id_role" id="role">
            <?php foreach($roles as $role) { ?>
            <option <?php if (isset($id_role) && ($id_role == $role->getId())) { echo "selected"; } ?>
              value="<?=$role->getId();?>"><?=$role->getRolename();?></option>
            <?php } ?>
          </select>
        </td>
      </tr>

      <tr>
        <td><label for="id_account">Vincular a una cuenta</label></td>
      </tr>
      <tr>
        <td colspan="2">
          <select name="id_account" id="id_account" onchange="Mostrar();">
            <?php foreach($accounts as $account) { ?>
            <option <?php if (isset($id_account) && ($id_account == $account->getId())) { echo "selected"; } ?>
              value="<?=$account->getId();?>"><?=$account->getUsername();?></option>
            <?php } ?>
            <option <?php if (isset($id_account) && ($id_account == 0)) { echo "selected"; } ?> value="0">Crear nueva cuenta</option>
          </select>
        </td>
      </tr>
    </table>
    <table id="account_table" class="oculto centrar">
      <tr>
        <td><label for="username">Nombre de usuario</label></td>
      </tr>
      <tr>
        <td colspan="2"><input type="text" name="username" value=""></td>
      </tr>
      <tr>
        <td><label for="email">Correo Electronico</label></td>
      </tr>
      <tr>
        <td colspan="2"><input type="email" name="email" value=""></td>
      </tr>
      <tr>
        <td><label for="password">Contraseña</label></td>
      </tr>
      <tr>
        <td colspan="2"><input type="password" name="password" value=""></td>
      </tr>
      <tr>
        <td><label for="password2">Repetir Contraseña</label></td>
      </tr>
      <tr>
        <td colspan="2"><input type="password" name="password2" value=""></td>
      </tr>
    </table>
    <table class="centrar" style="margin-bottom: 50px;">
      <tr>
        <td colspan="2"><input type="submit" class="submit" value="Guardar cambios"></td>
      </tr>
    </table>
  </form>

<script type="text/javascript">
function Validar() {
  var ok = true;
  var form = document.getElementsByName('form');

  if (notText(form.name.value)) ok = false;
  if (notText(form.surname.value)) ok = false;
  if (notText(form.dni.value)) ok = false;
  if (notText(form.address.value)) ok = false;
  if (notText(form.phone.value)) ok = false;
  if (notNumber(form.salary.value)) ok = false;

  if (SelectedIndex() == 0) {
    if (notText(form.username.value)) ok = false;
    if (notText(form.email.value)) ok = false;
    if (notText(form.password.value)) ok = false;
    if (notText(form.password2.value)) ok = false;

    if (form.password.value != form.password2.value) {
      alert("La contraseña debe coincidir");
      return false;
    }
  }

  if (!ok) {
    alert("Compruebe los campos");
  }
  return ok;
}

function MostrarRespuesta(datos) {
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
    MostrarRespuesta(respuestaAjax);
  });
}

function SelectedIndex() {
  var e = document.getElementById("id_account");
  return e.options[e.selectedIndex].value;
}

function Mostrar() {
  var tabla_account = document.getElementById("account_table");
  var id_account = SelectedIndex();
  if (id_account == 0) {
    tabla_account.classList.remove("oculto");
  } else {
    tabla_account.classList.add("oculto");
  }
}

window.onload = function() {
  Actualizar();
  Mostrar();
}
</script>
</body>
</html>
