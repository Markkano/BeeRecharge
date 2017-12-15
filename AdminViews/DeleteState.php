<form class="form" name="form" action="/<?= BASE_URL ?>gestionState/DeleteState" method="post" onsubmit="return Confirmar();">
  <tr>
    <td><h1>Eliminar Estado</h1></td>
  </tr>
  <table class="centrar">
    <tr>
      <td colspan="2">
        <select name="state" onchange="Actualizar()">
          <?php foreach($list as $state) { ?>
          <option value="<?= $state->getId();?>"><?= $state->getState(); ?></option>
          <?php } ?>
        </select>
      </td>
    </tr>
    <tr>
      <input hidden="hidden" type="text" name="name" value="">
    </tr>
    <tr>
      <td colspan="2"><input type="submit" class="submit" value="Eliminar Estado"></td>
    </tr>
  </table>
</form>

<script type="text/javascript">
function Actualizar() {
  form.name.value = document.form.state.options[form.state.selectedIndex].text;
}

function Confirmar() {
  return confirm("Desea elminar el Estado?");
}

window.onload = function() {Actualizar();}
</script>
</body>
</html>
