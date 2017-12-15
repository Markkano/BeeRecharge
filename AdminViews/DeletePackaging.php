<form class="form" name="form" action="/<?= BASE_URL ?>gestionPackaging/DeletePackaging" method="post" onsubmit="return Confirmar();">
  <table class="centrar">
    <tr>
      <td><h1>Eliminar Envase</h1></td>
    </tr>
    <tr>
      <td colspan="2">
        <select name="packaging" onchange="Actualizar()">
          <?php foreach($list as $packaging) { ?>
          <option value = "<?=$packaging->getId();?>"><?= $packaging->getDescription(); ?></option>
          <?php } ?>
        </select>
      </td>
    </tr>
    <tr>
      <input hidden="hidden" type="text" name="name" value="">
    </tr>
    <tr>
      <td colspan="2"><input type="submit" class="submit" value="Eliminar Envase"></td>
    </tr>
  </table>
</form>

<script type="text/javascript">
function Actualizar() {
  form.name.value = document.form.packaging.options[form.packaging.selectedIndex].text;
}

function Confirmar() {
  return confirm("Desea elminar el Envase?");
}

window.onload = function() {Actualizar();}
</script>
</body>
</html>
