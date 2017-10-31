<?php if (isset($alert) && !strcmp($alert, "") == 0) { ?>
  <div class="alert <?= $alert; ?>">
    <?= $msj; ?>
  </div>
<?php } ?>

<form class="form" name="form" action="/<?= BASE_URL ?>GestionConsults/FilterOrdersByClient" method="post">
  <table class="centrar">
    <tr>
      <td><h1>Buscar por Cliente</h1></td>
    </tr>
    <tr>
      <td><label for="name">DNI del Cliente</label></td>
    </tr>
    <tr>
      <td colspan="2"><input type="text" name="dni" value="<?php if(isset($client_dni)) echo $client_dni; ?>"></td>
    </tr>
    <tr>
      <td colspan="2"><input type="submit" class="submit" value="Buscar"></td>
    </tr>
  </table>
</form>
