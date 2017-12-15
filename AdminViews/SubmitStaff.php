<!--id_staff	name	surname	dni	address	phone	salary	id_account	id_role-->
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
<form class="form" name="form" action="/<?= BASE_URL ?>gestionStaff/SubmitStaff" method="post" onsubmit="return Validar();">
  <table class="centrar">
    <tr>
      <td><h1>Nuevo Staff</h1></td>
    </tr>
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
      <td colspan="2"><input type="text" name="surname" value="<?php if(isset($surname)) { echo $surname; } ?>"></td>
    </tr>
    <tr>
      <td><label for="dni">DNI</label></td>
    </tr>
    <tr>
      <td colspan="2"><input type="text" name="dni" value="<?php if(isset($dni)) { echo $dni; } ?>"></td>
    </tr>
    <tr>
      <td><label for="address">Direccion</label></td>
    </tr>
    <tr>
      <td colspan="2"><input type="text" name="address" value="<?php if(isset($address)) { echo $address; } ?>"></td>
    </tr>
    <tr>
      <td><label for="phone">Telefono</label></td>
    </tr>
    <tr>
      <td colspan="2"><input type="tel" name="phone" value="<?php if(isset($phone)) { echo $phone; } ?>"></td>
    </tr>
    <tr>
      <td><label for="salary">Sueldo</label></td>
    </tr>
    <tr>
      <td colspan="2"><input type="number" step="0.1" min="0" name="salary" value="<?php if(isset($salary)) { echo $salary; } ?>"></td>
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
  <table id="account" class="oculto centrar">
    <tr>
      <td><label for="username">Nombre de usuario</label></td>
    </tr>
    <tr>
      <td colspan="2"><input type="text" name="username" value="<?php if(isset($username)) { echo $username; } ?>"></td>
    </tr>
    <tr>
      <td><label for="email">Correo Electronico</label></td>
    </tr>
    <tr>
      <td colspan="2"><input type="email" name="email" value="<?php if(isset($email)) { echo $email; } ?>"></td>
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
      <td colspan="2"><input type="submit" class="submit" value="Agregar Staff"></td>
    </tr>
  </table>
</form>

<script type="text/javascript">
function Validar() {
  var ok = true;
  var form = document.form;
//name	surname	dni	address	phone	salary	id_account	id_role
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

function SelectedIndex() {
  var e = document.getElementById("id_account");
  return e.options[e.selectedIndex].value;
}

function Mostrar() {
  var tabla_account = document.getElementById("account")
  var id_account = SelectedIndex();
  if (id_account == 0) {
    tabla_account.classList.remove("oculto");
  } else {
    tabla_account.classList.add("oculto");
  }
}

window.onload = Mostrar();
</script>
</body>
</html>
