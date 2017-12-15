<form class="form" name="form" method="post" action="/<?= BASE_URL ?>gestionSubsidiary/ManageMarkers">
  <table class="centrar">
    <tr>
      <td colspan="2"><h1>Modificar Marcadores</h1></td>
    </tr>
    <tr>
      <td colspan="2">
        <select name="id" id="subsidiary" onchange="Actualizar()" style="margin-left: 0px;">
          <?php foreach($list as $subsidiary) { ?>
          <option value="<?=$subsidiary->getId();?>"><?=$subsidiary->getAddress();?></option>
          <?php } ?>
        </select>
      </td>
    </tr>
    <tr>
      <td><input type="hidden" name="lat" value=""></td>
      <td><input type="hidden" name="lon" value=""></td>
    </tr>
    <tr>
      <td colspan="2">
        <div id="map" style="height: 400px; width:400px;"></div>
      </td>
    </tr>
    <tr>
      <td colspan="2"><input type="submit" class="submit" value="Guardar cambios" style="margin-left: 0px;"></td>
    </tr>
  </table>
</form>
<script src="/<?= BASE_URL ?>Js/GoogleMaps.js" charset="utf-8"></script>
<script type="text/javascript">
function Actualizar() {
  var subsidiary = form.subsidiary.options[form.subsidiary.selectedIndex].value;
  Ajax('/<?= BASE_URL ?>Ajax/GetSubsidiary', 'post', 'msj='+subsidiary, function(respuestaAjax) {
    Mostrar(respuestaAjax);
  });
}
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBCBbhiQn8Z1G7-uj5IVlDj1pSYKlgfT3I&callback=GenerateMap">
</script>
