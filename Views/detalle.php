 <table class="tabla-envases pizarra expandir-fondo" align="center" style="font-family: 'Old Bookshop'">

        <tr class="f">
          <td>
            <label for="name">Nombre:</label>
            <input type="text" name="name" value="<?= $order->getClient()->getSurname().' ,'.$order->getClient()->getName(); ?>" disabled>
          </td>
          <td>
            <label for="date">Fecha:</label>
            <input type="text" name="date" value="<?= $order->getOrderDate(); ?>" disabled>
          </td>
        </tr>
        <tr class="f"> <!-- Sucursal -->
          <td><label for="subsidiary">Sucursal:</label></td>
          <td>
            <input type="text" name="subsidiary" value="<?= $order->getSubsidiary()->getAddress(); ?>" disabled>
          </td>
        </tr>
        <?php if($order->getSend()!= null){?>
        <tr>
          <td>Fecha de envio:</td>
          <td><?=$order->getSend()->getSendDate();?></td>
        </tr>
        <tr>
          <td>Direccion de envio:</td>
          <td><?=$order->getSend()->getAddress();?></td>
        </tr>
        <?php } ?>
      </table>
       <table class="tabla-envases pizarra expandir-fondo" align="center" style="font-family: 'Old Bookshop'"> <!-- detalle del pedido  !-->
        <tr>
          <td>CERVEZA</td>
          <td>ENVASE</td>
          <td>CANTIDAD</td>
          <td>SUBTOTAL</td>
          <td></td>
        </tr>
        <?php $total = 0;
        foreach ($order->getOrderLines() as $orderline) {
          $subtotal = $orderline->getAmount() * $orderline->getPrice();
          $total += $subtotal; ?>
          <tr class="f">
            <td><?= $orderline->getBeer()->getName(); ?></td>
            <td><?= $orderline->getPackaging()->getDescription(); ?></td>
            <td><?= $orderline->getAmount(); ?></td>
            <td><?= '$'.$subtotal; ?></td>
          </tr>
        <?php }?>
        <tr>
          <td colspan="5" style="padding: 15px 50px 15px 0px; text-align: right;">Total: $<?= $order->getTotal(); ?></td>
        </tr>
        <!-- acciones del pedido  !-->
        <tr>
          <td><a href="/<?= BASE_URL ?>ConsultarEstado" ><button class="btn-volver" type="button">Volver</button></a></td>
        </tr>
      </table>
