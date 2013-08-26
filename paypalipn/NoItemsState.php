<?php

/**
 * Description of NoItemsState
 *
 * @author nic.stransky
 */
class NoItemsState implements State {
	private $cart;
	
	public function __construct(Cart $cart) {
		$this->cart = $cart;
	}
	
	public function addItem($item) {
		//$this->items[] = $item; this belongs in the Cart class so it can manage the Cart's $items array, not the NoItemsState's $items array
		$this->cart->appendItemToItemsArray($item);
		$this->cart->setState($this->cart->getHasItemsState());
	}
	
	public function sendToPaypal() {
		out("There are no items in the cart, so you can't send it to Paypal yet.");
	}
	
	public function paypalResponseFailure() {
		out("Paypal Response Failure should never happen. Im in the NoItemsState.");
	}
	
	public function sendEmailFailureNotice() {
		out("Send Email Failure Notice should never happen. Im in the NoItemsState.");
	}
	
	public function paypalResponseSuccess() {
		out("Paypal Response Success should never happen. Im in the NoItemsState.");
	}
	
	public function sendEmailWithAttachment() {
		out("Send Email With Attachment should never happen. Im in the NoItemsState.");
	}
	
	public function destroyCart() {
		out("Destroy Cart should never happen. Im in the NoItemsState.");
	}
	
	public function __toString() {
		return "NoItemsState. There are currently no items in the cart.";
	}
	
}

?>
