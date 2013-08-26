<?php

/**
 * Description of PaymentFailedState
 *
 * @author nic.stransky
 */
class PaymentFailedState implements State {
	private $cart;
	
	public function __construct(Cart $cart) {
		$this->cart = $cart;
	}
	
	public function addItem($item) {
 		out("You have attempted to add an item to your cart, but I'm in the Payment Failed State.");
	}
	
	public function sendToPaypal() {
		out("Sending your cart to Paypal to complete the purchase.");
		$this->cart->setState($this->cart->getWaitingForPaypalResponseState());
		// TODO post to paypal here after state has been saved to database
	}
	
	public function paypalResponseFailure() {
		out("Paypal Response Failure should never happen. Im in the PaymentFailedState.");
	}
	
	public function sendEmailFailureNotice() {
		$this->cart->deliverFailureByEmail();
	}
	
	public function paypalResponseSuccess() {
		out("Paypal Response Success should never happen. Im in the PaymentFailedState.");
	}
	
	public function sendEmailWithAttachment() {
		out("Send Email With Attachment should never happen, I'm in the PaymentFailedState.");
	}
	
	public function destroyCart() {
		$this->cart->deleteAllItems();
		$this->cart->setState($this->cart->getNoItemsState());
	}
	
	public function __toString() {
		return "The IPN response came back and was a failure.";
	}
	
}

?>
