<form class="form" name="form" action="/<?= BASE_URL ?>gestionStaff/DeleteStaff" method="post" onsubmit="return Confirmar();">
  <tr>
    <td><h1>Eliminar Staff</h1></td>
  </tr>
  <table class="centrar">
    <tr>
      <td colspan="2">
        <select name="staff" onchange="Actualizar()">
          <?php foreach($list as $staff) { ?>
          <option <?php if (isset($id_staff) && ($id_staff == $staff->getId())) { echo "selected"; } ?>
            value="<?=$staff->getId();?>"><?= $staff->getSurname().", ".$staff->getName();?></option>
          <?php } ?>
        </select>
      </td>
    </tr>
    <tr>
      <input hidden="hidden" type="text" name="name" value="">
    </tr>
    <tr>
      <td colspan="2"><input type="submit" class="submit" value="Eliminar Staff"></td>
    </tr>
  </table>
</form>

<script type="text/javascript">
function Actualizar() {
  form.name.value = document.form.staff.options[form.staff.selectedIndex].text;
}

function Confirmar() {
  return confirm("Desea elminar el Staff?");
}

window.onload = function() {Actualizar();}
</script>
</body>
</html>
