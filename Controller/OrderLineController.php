<?php namespace Controller;

use Model\Order as Order;
use Model\OrderLine as OrderLine;

class OrderLineController {

	private $orderLineDAO;

	public function Index() {}

	public function DeleteOrderLine($pos) {
		if (isset($_SESSION['order'])) {
			$order = $_SESSION['order'];
			$pos--;
			$order->DeleteOrderLine($pos);
			header('location: /'.BASE_URL.'Lobby/SubmitOrder');
		}
	}
} ?>
