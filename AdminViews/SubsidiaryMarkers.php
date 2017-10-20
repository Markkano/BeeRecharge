<?php if (isset($alert) && !strcmp($alert, "") == 0) { ?>
  <div class="alert <?= $alert; ?>">
    <?= $msj; ?>
  </div>
<?php } ?>

<form class="form" name="form" method="post" action="/gestionSubsidiary/ManageMarkers">
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
      <td><input type="text" name="lat" value=""></td>
      <td><input type="text" name="lon" value=""></td>
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
<script src="/Js/GoogleMaps.js" charset="utf-8"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBCBbhiQn8Z1G7-uj5IVlDj1pSYKlgfT3I&callback=GenerateMap">
</script>
