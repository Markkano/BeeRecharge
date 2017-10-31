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
    <td>Orden</td>
    <td>Cliente</td>
    <td>Fecha</td>
    <td>Estado</td>
    <td>Total</td>
    <td>Sucursal</td>
    <!-- Envio -->
  </tr>
  <?php foreach($list as $order) { ?>

    <tr>
      <td><?= $order->getOrderNumber(); ?></td>
      <td><?= $order->getClient()->getSurname().', '.$order->getClient()->getName(); ?></td>
      <td><?= $order->getOrderDate(); ?></td>
      <td><?= $order->getState()->getState(); ?></td>
      <td><?= $order->getTotal(); ?></td>
      <td><?= $order->getSubsidiary()->getAddress(); ?></td>
    </tr>

  <?php } ?>
</table>
