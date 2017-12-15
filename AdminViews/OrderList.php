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
    <td><button id="all" onclick="UpdateAll()" style="visibility: hidden;" type="button">Modificar Todos</button></td>
    <!-- Envio -->
  </tr>
  <?php foreach($list as $order) { ?>
    <tr>
      <form name="form" action="/<?= BASE_URL; ?>UpdateOrder/Update" method="post">
        <input type="hidden" name="order_number" value="<?= $order->getOrderNumber(); ?>">
        <td><?= $order->getOrderNumber(); ?></td>
        <td><?= $order->getClient()->getSurname().', '.$order->getClient()->getName(); ?></td>
        <td><?= $order->getOrderDate(); ?></td>
        <td>
          <select id="dropdown<?= $order->getOrderNumber(); ?>" onchange="Mostrar('<?= $order->getOrderNumber()."','".$order->getState()->getId(); ?>');" >
          <?php foreach($state_list as $state) { ?>
            <option value="<?= $state->getId(); ?>" <?php if ($state->getId() == $order->getState()->getId()) { echo "selected"; } ?>><?= $state->getState(); ?></option>
          <?php } ?>
        </select>
        </td>
        <td><?= $order->getTotal(); ?></td>
        <td><?= $order->getSubsidiary()->getAddress(); ?></td>
        <td><button id="select<?= $order->getOrderNumber(); ?>" onclick="UpdateState(<?= $order->getOrderNumber(); ?>)" style="visibility: hidden;" type="button">Modificar Estado</button></td>
      </form>
    </tr>
  <?php } ?>
</table>
<script type="text/javascript">
  var count = 0;

  function UpdateAll() {
    inputs = document.getElementsByTagName('input');
    for (i = 0; i < inputs.length; i++) {
      if (inputs[i].name == "order_number") {
        UpdateState(inputs[i].value);
      }
    }
  }

  function UpdateState(order_number) {
    var id_state = Estado(order_number);
    Ajax('/<?= BASE_URL ?>UpdateOrder/Update', 'post', '&order_number='+order_number+'&id_state='+id_state, function(respuesta) {
      if (respuesta != 'error') {
        Ocultar(order_number);
      } else {
        alert("Ocurrio un problema al actualizar el estado");
      }
    });
  }

  function Ocultar(order_number) {
    if (count > 0) {
      count--;
    }
    id_state = Estado(order_number);
    document.getElementById('select'+order_number).style.visibility = "hidden";
    Count();
  }

  function Mostrar(order_number, aux_id_state) {
    var id_state = Estado(order_number);
    if (aux_id_state != id_state) {
      count++;
      document.getElementById('select'+order_number).style.visibility = "visible";
    } else {
      Ocultar(order_number);
    }
    Count();
  }

  function Count() {
    if (count > 1) {
      document.getElementById("all").style.visibility = "visible";
    } else {
      document.getElementById("all").style.visibility = "hidden";
    }
  }

  function Estado(order_number) {
    var e = document.getElementById("dropdown"+order_number);
    return e.options[e.selectedIndex].value;
  }
</script>
