<body class="fondo-carga expandir-fondo">
 <div class="centrar" style="width: 80%; margin-top: 40px;">
	 <form action='/<?= BASE_URL ?>Order/NewOrder' method='post'>
		<!-- cabecera del pedido  !-->
		<center>
			<p class="tabla-envases pizarra expandir-fondo" style="font-family: 'Old Bookshop'"> INGRESO  DE  PEDIDO </p></center>
      <table align='center' class="tabla-envases pizarra expandir-fondo">
      	<tr>
      		<td>Fecha: </td>
      		<td><input type="text" name=""
      			value="<?= $order->getOrderDate(); ?>" disabled></td>
      	</tr>
      	<tr>
      		<td>Sucursal: </td>
      		<td>
        		<?php if ($subsidiary == null) { ?>
        			<a href="/<?= BASE_URL ?>Lobby/ElegirSucursal" class="btn-volver"> Ingresar Sucursal</a>
        		<?php } else { ?>
        			<input type="text" name="sucursal" value="<?= $subsidiary->getAddress(); ?>" disabled>
        		<?php } ?>
      		</td>
      	</tr>
      	<tr><td colspan="2" align="left">Detalle: </td></tr>
      </table>

      <!-- detalle del pedido  !-->
      <table align='center' class="tabla-envases pizarra expandir-fondo">
    	   <center><tr>
          <td>CERVEZA</td>
          <td>ENVASE</td>
          <td>SUBTOTAL</td>
        	</tr></center>

        	<?php
            $orderlines = $order->getOrderLines();
            $total = 0;

            foreach ($orderlines as $orderline) {?>
            <tr>
              <td><?= $orderline->getBeer()->getName(); ?></td>
              <td><?= $orderline->getPackaging()->getDescription(); ?></td>
              <td><?php $subtotal = $orderline->getAmount() * $orderline->getPrice();
                    echo '$'.$subtotal;?></td>
              <?php $total = $total + $subtotal; ?>
            </tr>
          <?php }?>
          <tr>
          	<td colspan="2">TOTAL</td>
          	<td align="right"><?='$'.$total;?></td>>
          </tr>
        <!-- acciones del pedido  !-->
       	<tr>
          <input type="hidden" name="total" value=<?= $total;?>>
          <td><a href="/<?= BASE_URL ?>Lobby" class="btn-volver">Ingresar Nueva Cerveza</a></td>
          <td align="right"><a href="/<?= BASE_URL ?>Order/DeleteOrder" class="btn-volver"> Eliminar Pedido</td>
          <td><input type="submit" name="enter" value='Ingresar Pedido' class="submit"></td>
        </tr>
      </table>
    </form>
  </div>
</body>
</html>
