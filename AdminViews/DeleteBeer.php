<form class="form" name="form" action="/<?= BASE_URL ?>gestionBeer/DeleteBeer" method="post" onsubmit="return Confirmar();">
  <tr>
    <td><h1>Eliminar Cerveza</h1></td>
  </tr>
  <table class="centrar">
    <tr>
      <td colspan="2">
        <select name="beer" onchange="Actualizar()">
          <?php foreach($list as $beer) { ?>
          <option <?php if (isset($id_beer) && ($id_beer == $beer->getId())) { echo "selected"; } ?>
              value="<?=$beer->getId();?>"><?=$beer->getName();?></option>
          <?php } ?>
        </select>
      </td>
    </tr>
    <tr>
      <input hidden="hidden" type="text" name="name" value="">
    </tr>
    <tr>
      <td colspan="2"><input type="submit" class="submit" value="Eliminar Cerveza"></td>
    </tr>
  </table>
</form>

<script type="text/javascript">
function Actualizar() {
  form.name.value = document.form.beer.options[form.beer.selectedIndex].text;
}

function Confirmar() {
  return confirm("Desea elminar la Cerveza?");
}

window.onload = function() {Actualizar();}
</script>
</body>
</html>
