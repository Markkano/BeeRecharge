<form class="form" name="form" action="/<?= BASE_URL ?>gestionState/UpdateState" method="post" onsubmit="return Validar();">
  <table class="centrar">
    <tr>
      <td><h1>Modificar Estado</h1></td>
    </tr>
    <tr>
      <td colspan="2">
        <select name="id" id="state" onchange="Actualizar()">
          <?php foreach($list as $state) { ?>
          <option <?php if (isset($id_state) && ($id_state == $state->getId())) { echo "selected"; } ?>
            value="<?= $state->getId(); ?>"><?= $state->getState(); ?></option>
          <?php } ?>
        </select>
      </td>
    </tr>
    <tr>
      <td><label for="description">Estado</label></td>
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

  if (notText(form.description.value)) ok = false;

  if (!ok) {
    alert("Compruebe los campos");
  }

  return ok;
}

function Mostrar(datos) {
  var state = JSON.parse(datos);
  var form = document.form;
  form.description.value = state.state;
}

function Actualizar() {
  var state = form.state.options[form.state.selectedIndex].value;
  Ajax('/<?= BASE_URL ?>Ajax/GetState', 'post', 'msj='+state, function(respuestaAjax) {
    Mostrar(respuestaAjax);
  });
}

window.onload = function() {Actualizar();}
</script>
</body>
</html>
