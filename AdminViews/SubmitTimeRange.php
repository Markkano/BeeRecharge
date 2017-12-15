<form class="form" name="form" action="/<?= BASE_URL ?>gestionTimeRange/SubmitTimeRange" method="post" onsubmit="return Validar();">
  <table class="centrar">
    <tr>
      <td><h1>Rango Horario Nuevo</h1></td>
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
      <td colspan="2"><input type="submit" class="submit" value="Agregar Horario" ></td>
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
</script>
</body>
</html>
