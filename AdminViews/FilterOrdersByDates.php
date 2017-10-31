<?php if (isset($alert) && !strcmp($alert, "") == 0) { ?>
  <div class="alert <?= $alert; ?>">
    <?= $msj; ?>
  </div>
<?php } ?>

<form class="form" name="form" action="/<?= BASE_URL ?>GestionConsults/FilterOrdersByDates" method="post">
  <table class="centrar">
    <tr>
      <td colspan="2"><h1>Buscar por Fechas</h1></td>
    </tr>
    <tr>
      <td><label for="name">Rango de fechas</label></td>
    </tr>
    <tr>
      <td><input type="date" name="from"></td>
      <td><input type="date" name="to"></td>
    </tr>
    <tr>
      <td colspan="2"><input type="submit" class="submit" value="Buscar"></td>
    </tr>
  </table>
</form>
