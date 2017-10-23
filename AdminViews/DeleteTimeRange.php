<?php if (isset($alert) && !strcmp($alert, "") == 0) { ?>
  <div class="alert <?= $alert; ?>">
    <?= $msj; ?>
  </div>
<?php } ?>
<form class="form" name="form" action="/gestionTimeRange/DeleteTimeRange" method="post" onsubmit="return Confirmar();">
  <tr>
    <td><h1>Eliminar Horario</h1></td>
  </tr>
  <table class="centrar">
    <tr>
      <td colspan="2">
        <select name="timeRange" onchange="Actualizar()">
          <?php foreach($list as $timeRange) { ?>
          <option value="<?=$timeRange->getId();?>"><?=$timeRange->getFrom().' -  '.$timeRange->getTo();?></option>
          <?php } ?>
        </select>
      </td>
    </tr>
    <tr>
      <td colspan="2"><input type="submit" class="submit" value="Eliminar Horario"></td>
    </tr>
  </table>
</form>

<script type="text/javascript">
function Actualizar() {
  form.name.value = document.form.timeRange.options[form.timeRange.selectedIndex].text;
}

function Confirmar() {
  return confirm("Desea elminar el Rango Horario?");
}

window.onload = function() {Actualizar();}
</script>
</body>
</html>
