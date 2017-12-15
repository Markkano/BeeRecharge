<form class="form" name="form" action="/<?= BASE_URL ?>gestionState/SubmitState" method="post" onsubmit="return Validar();">
  <table class="centrar">
    <tr>
      <td><h1>Nuevo Estado</h1></td>
    </tr>
    <tr>
      <td><label for="state">Estado</label></td>
    </tr>
    <tr>
      <td colspan="2"><input type="text" name="state" value=""></td>
    </tr>
    <tr>
      <td colspan="2"><input type="submit" class="submit" value="Agregar Estado"></td>
    </tr>
  </table>
</form>

<script type="text/javascript">
function Validar() {
  var ok = true;
  var form = document.form;

  if (notText(form.state.value)) ok = false;

  if (!ok) {
    alert("Compruebe los campos");
  }
  return ok;
}
</script>
</body>
</html>
