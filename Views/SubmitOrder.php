<body class="expandir-fondo">
<style media="screen">
  .f {
    font-family: 'Old Bookshop';
  }
</style>
  <div class="pizarra expandir-fondo orden-background">
    <form class="" action="/<?= BASE_URL ?>Order/NewOrder" method="post">
      <table class="orden-head">
        <tr>
          <td colspan="2" style="font-size: 36px"><b>Confirmar Orden</b></td>
        </tr>
        <tr class="f">
          <td>
            <label for="name">Nombre:</label>
            <input type="text" name="name" value="<?= $order->getClient()->getSurname().' ,'.$order->getClient()->getName(); ?>" disabled>
          </td>
          <td>
            <label for="date">Fecha:</label><br/>
            <input type="text" name="date" value="<?= $order->getOrderDate(); ?>" disabled>
          </td>
        </tr>
        <tr class="f"> <!-- Sucursal -->
          <td colspan=""><label for="subsidiary">Sucursal:</label>
            <?php if ($subsidiary == null) { ?>
            <a href="/<?= BASE_URL ?>Lobby/ElegirSucursal"><button type="button">Ingresar Sucursal</button></a>
            <?php } else { ?>
            <input type="text" name="subsidiary" value="<?= $subsidiary->getAddress(); ?>" disabled>
            <?php } ?>
          </td>
          <td>
            <label for="send">Elegir método de envío</label>
            <select class="" name="send" style="width:180px;">
              <option value="1">Retiro en Sucursal</option>
              <option value="2">Envío a Domicilio</option>
            </select>
        </tr>
      </table>
      <table class="orden-body" style="margin-top: 30px; font-size: 18px;"> <!-- detalle del pedido  !-->
        <tr>
          <td>CERVEZA</td>
          <td>ENVASE</td>
          <td>CANTIDAD</td>
          <td>SUBTOTAL</td>
          <td></td>
        </tr>
        <?php $total = 0;
        $i = 1;
        foreach ($order->getOrderLines() as $orderline) {
          $subtotal = $orderline->getAmount() * $orderline->getPrice();
          $total += $subtotal; ?>
          <tr class="f">
            <td><?= $orderline->getBeer()->getName(); ?></td>
            <td><?= $orderline->getPackaging()->getDescription(); ?></td>
            <td><?= $orderline->getAmount(); ?></td>
            <td><?= '$'.$subtotal; ?></td>
            <td><a href="/<?= BASE_URL; ?>OrderLine/DeleteOrderLine/<?= $i; ?>">Eliminar</a></td>
          </tr>
        <?php $i++; }?>
        <tr>
          <td colspan="5" style="padding: 15px 50px 15px 0px; text-align: right;">Total: $<?= $total; ?></td>
        </tr>
        <!-- acciones del pedido  !-->
        <tr>
          <input type="hidden" name="total" value=<?= $total;?>>

          <td><a href="/<?= BASE_URL ?>Lobby" class="btn-order"><button type="button">Ingresar otra Cerveza</button></a></td>
          <td><a href="/<?= BASE_URL ?>Order/DeleteOrder" class="btn-order"><button type="button">Eliminar Pedido</button></td>
          <td><input type="submit" name="" value='Ingresar Pedido'
          <?php if ($order->getSubsidiary() == null) { ?>
            title="Seleccione una sucursal" disabled
          <?php } elseif (empty($order->getOrderLines())) { ?>
            title="Seleccione al menos una cerveza" disabled
          <?php } ?>></td>
        </tr>
      </table>
    </form>
  </div>
</body>
</html>
