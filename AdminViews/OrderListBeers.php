<style media="screen">
  .tabla-orders {
    border-collapse: collapse;
    margin-top: 20px;
  }
  .tabla-orders td {
    padding: 10px 20px;
    border: 1px solid black;
  }

</style>

<table class="tabla-orders centrar">
  <tr>
    <td>Nombre</td>
    <td>Total Vendido</td>
  </tr>
  <?php $indice=0; 
  while($indice<sizeof($list)) {?>
    <tr>
      <td><p><?=$list[$indice];?></p></td>
      <?php $indice++; ?>
      <td><?=$list[$indice].' litros';?></td>
    </tr>

  <?php 
$indice++; 
}?>
</table>