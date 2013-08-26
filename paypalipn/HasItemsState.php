<?php

/**
 * Description of HasItemsState
 *
 * @author nic.stransky
 */
class HasItemsState implements State {
	private $cart;
	
	public function __construct(Cart $cart) {
		$this->cart = $cart;
	}
	
	public function addItem($item) {
		$this->cart->appendItemToItemsArray($item);
	}
	
	public function sendToPaypal() {
		out("Sending your cart to Paypal to complete the purchase.");
		$this->cart->setState($this->cart->getWaitingForPaypalResponseState());
		// TODO post to paypal here after state has been saved to database
	}
	
	public function paypalResponseFailure() {
		out("Paypal Response Failure should never happen. Im in the HasItemsState.");
	}
	
	public function sendEmailFailureNotice() {
		out("Send Email Failure Notice should never happen. Im in the HasItemsState.");
	}
	
	public function paypalResponseSuccess() {
		out("Paypal Response Success should never happen. Im in the HasItemsState.");
	}
	
	public function sendEmailWithAttachment() {
		out("Send Email With Attachment should never happen. Im in the HasItemsState.");
	}
	
	public function destroyCart() {
		$this->cart->deleteAllItems();
		$this->cart->setState($this->cart->getNoItemsState());
	}
	
	public function __toString() {
		return "HasItemsState. The cart contains items.";
	}
	
}

?>
