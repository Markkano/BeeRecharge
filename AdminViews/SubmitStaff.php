<!--id_staff	name	surname	dni	address	phone	salary	id_account	id_role-->
<?php if (isset($alert) && !strcmp($alert, "") == 0) { ?>
  <div class="alert <?= $alert; ?>">
    <?= $msj; ?>
  </div>
<?php } ?>

<form class="form" name="form" action="/<?= BASE_URL ?>gestionStaff/Submit" method="post" onsubmit="return Validar();">
  <table class="centrar">
    <tr>
      <td><h1>Nuevo Staff</h1></td>
    </tr>
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

  if (!ok) {
    alert("Compruebe los campos");
  }
  return ok;
}
</script>
</body>
</html>
