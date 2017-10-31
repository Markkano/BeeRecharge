<?php if (isset($alert) && !strcmp($alert, "") == 0) { ?>
  <div class="alert <?= $alert; ?>">
    <?= $msj; ?>
  </div>
<?php } ?>

<form class="form" name="form" action="/<?= BASE_URL ?>GestionConsults/FilterOrdersBySubsidiary" method="post">
  <table class="centrar">
    <tr>
      <td><h1>Buscar por Sucursal</h1></td>
    </tr>
    <tr>
      <td colspan="2">
        <select name="id">
          <?php foreach($subsidiary_list as $subsidiary) { ?>
          <option <?php if ($id_subsidiary == $subsidiary->getId()) echo "selected"; ?>
            value="<?=$subsidiary->getId();?>"><?=$subsidiary->getAddress();?></option>
          <?php } ?>
        </select>
      </td>
    </tr>
    <tr>
      <td colspan="2"><input type="submit" class="submit" value="Buscar"></td>
    </tr>
  </table>
</form>
