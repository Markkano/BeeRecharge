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
      <td><a href="/<?= BASE_URL ?>GestionConsults/FilterOrdersByClient/<?= $order->getClient()->getDNI(); ?>"><?= $order->getClient()->getSurname().', '.$order->getClient()->getName(); ?></a></td>
      <td><?= $order->getOrderDate(); ?></td>
      <td><?= $order->getState()->getState(); ?></td>
      <td><?= $order->getTotal(); ?></td>
      <td><a href="/<?= BASE_URL ?>GestionConsults/FilterOrdersBySubsidiary/<?= $order->getSubsidiary()->getId(); ?>"><?= $order->getSubsidiary()->getAddress(); ?></a></td>
    </tr>

  <?php } ?>
</table>
