<?php if (isset($alert) && !strcmp($alert, "") == 0) { ?>
  <div class="alert <?= $alert; ?>">
    <?= $msj; ?>
  </div>
<?php } ?>
<form class="form" name="form" action="/GestionSubsidiary/DeleteSubsidiary" method="post" onsubmit="return Confirmar();">
  <table class="centrar">
    <tr>
      <td><h1>Eliminar Sucursal</h1></td>
    </tr>
    <tr>
      <td colspan="2">
        <select name="subsidiary" onchange="Actualizar()">
          <?php foreach($list as $subsidiary) { ?>
          <option value="<?=$subsidiary->getId();?>"><?=$subsidiary->getAddress();?></option>
          <?php } ?>
        </select>
      </td>
    </tr>
    <tr>
      <input hidden="hidden" type="text" name="address" value="">
    </tr>
    <tr>
      <td colspan="2"><input type="submit" class="submit" value="Eliminar Sucursal"></td>
    </tr>
  </table>
</form>

<script type="text/javascript">
function Actualizar() {
  form.address.value = document.form.subsidiary.options[form.subsidiary.selectedIndex].text;
}

function Confirmar() {
  return confirm("Desea elminar la Sucursal?");
}

window.onload = function() {Actualizar();}
</script>
</body>
</html>
