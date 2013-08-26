<?php

/**
 * Description of DeliveryCompletedState
 *
 * @author nic.stransky
 */
class DeliveryCompletedState implements State {
	private $cart;
	
	public function __construct(Cart $cart) {
		$this->cart = $cart;
	}
	
	public function addItem($item) {
 		out("You have attempted to add an item to your cart, but this cart has been paid for and delivered and we are in the DeliveryCompleteState.");
	}
	
	public function sendToPaypal() {
		out("You can't send to Paypal, I'm in the DeliveryCompleteState. Your only option is to destroy the cart.");
	}
	
	public function paypalResponseFailure() {
		out("Paypal Response Failure should never happen, I'm in the DeliveryCompleteState. Your only option is to destroy the cart.");
	}
	
	public function sendEmailFailureNotice() {
		out("Send Email Failure Notice should never happen, I'm in the DeliveryCompleteState. Your only option is to destroy the cart.");
	}
	
	public function paypalResponseSuccess() {
		out("Paypal Response Success should never happen, I'm in the DeliveryCompleteState. Your only option is to destroy the cart.");
	}
	
	public function sendEmailWithAttachment() {
		out("Send Email With Attachment should never happen, I'm in the DeliveryCompleteState. Your only option is to destroy the cart.");
	}
	
	public function destroyCart() {
		$this->cart->deleteAllItems();
		$this->cart->setState($this->cart->getNoItemsState());		
	}
	
	public function __toString() {
		return "DeliveryCompletedState. You can delete the cart.";
	}
	
}

?>
