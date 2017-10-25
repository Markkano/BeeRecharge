<?php if (isset($alert) && !strcmp($alert, "") == 0) { ?>
  <div class="alert <?= $alert; ?>">
    <?= $msj; ?>
  </div>
<?php } ?>
<form class="form" name="form" action="/<?= BASE_URL ?>gestionTimeRange/UpdateTimeRange" method="post" onsubmit="return Validar();">
  <table class="centrar">
    <tr>
      <td><h1>Modificar Rango Horario</h1></td>
    </tr>
    <tr>
      <td colspan="2">
        <select name="timeRange" id="timeRange" onchange="Actualizar()">
          <?php foreach($list as $timeRange) { ?>
          <option value="<?=$timeRange->getId();?>"><?=$timeRange->getFrom().' - '.$timeRange->getTo();?></option>
          <?php } ?>
        </select>
      </td>
    </tr>
    <tr>
      <td><label for="from">Desde</label></td>
    </tr>
    <tr>
      <td colspan="2"><input type="text" name="from" value=""></td>
    </tr>
    <tr>
      <td><label for="to">Hasta</label></td>
    </tr>
    <tr>
      <td colspan="2"><input type="text" name="to" value=""></td>
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

  if (notText(form.from.value)) ok = false;
  if (notText(form.to.value)) ok = false;

  if (!ok) {
    alert("Compruebe los campos");
  }

  return ok;
}

function Mostrar(datos) {
  var timeRange = JSON.parse(datos);
  var form = document.form;
  form.from.value = timeRange.from;
  form.to.value = timeRange.to;
}

function Actualizar() {
  var timeRange = form.timeRange.options[form.timeRange.selectedIndex].value;
  Ajax('/<?= BASE_URL ?>Ajax/GetTimeRange', 'post', 'msj='+timeRange, function(respuestaAjax) {
    Mostrar(respuestaAjax);
  });
}

window.onload = function() {Actualizar();}
</script>
</body>
</html>
