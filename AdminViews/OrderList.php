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
    <td></td>
    <!-- Envio -->
  </tr>
  <?php foreach($list as $order) { ?>
    <tr>
      <form action="/<?= BASE_URL; ?>UpdateOrder/Update" method="post">
        <input type="hidden" name="" value="<?= $order->getOrderNumber(); ?>">
        <td><?= $order->getOrderNumber(); ?></td>
        <td><?= $order->getClient()->getSurname().', '.$order->getClient()->getName(); ?></td>
        <td><?= $order->getOrderDate(); ?></td>
        <td>
          <select id="dropdown" onchange="Mostrar('<?= $order->getOrderNumber(); ?>');" >
          <?php foreach($state_list as $state) { ?>
            <option value="<?= $state->getId(); ?>" <?php if ($state->getId() == $order->getState()->getId()) { echo "selected"; } ?>><?= $state->getState(); ?></option>
          <?php } ?>
        </select>
        </td>
        <td><?= $order->getTotal(); ?></td>
        <td><?= $order->getSubsidiary()->getAddress(); ?></td>
        <td><a id="select<?= $order->getOrderNumber(); ?>" href="" style="visibility: hidden;" <button type="button">Modificar Estado</button></a></td>
      </form>
    </tr>
  <?php } ?>
</table>
<script type="text/javascript">
  function Mostrar(order_number) {
    var e = document.getElementById("dropdown");
    var id_state = e.options[e.selectedIndex].value;
    document.getElementById('select'+order_number).style.visibility = "visible";
    document.getElementById('select'+order_number).href = "/<?= BASE_URL ?>UpdateOrder/Update/"+order_number+"/"+id_state;
  }
</script>
