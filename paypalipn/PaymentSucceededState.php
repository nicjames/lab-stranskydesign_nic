<?php

/**
 * Description of PaymentSucceededState
 *
 * @author nic.stransky
 */
class PaymentSucceededState implements State {
	private $cart;
	
	public function __construct(Cart $cart) {
		$this->cart = $cart;
	}
	
	public function addItem($item) {
 		out("You have attempted to add an item to your cart, but I'm in the Payment Succeeded State.");
	}
	
	public function sendToPaypal() {
		out("You have attempted to send to paypal, but I'm in the Payment Succeeded State.");
	}
	
	public function paypalResponseFailure() {
		out("Paypal Response Failure should never happen. Im in the PaymentSucceededState.");
	}
	
	public function sendEmailFailureNotice() {
		out("Send Email Failure Notice should never happen. Im in the PaymentSucceededState.");
	}
	
	public function paypalResponseSuccess() {
		out("Paypal Response Success should never happen. Im in the PaymentSucceededState.");
	}
	
	public function sendEmailWithAttachment() {
		$this->cart->deliverItemsByEmail();
		$this->cart->setState($this->cart->getDeliveryCompletedState());
	}
	
	public function destroyCart() {
		out("Destroy Cart should never happen. Im in the PaymentSucceededState.");
	}
	
	public function __toString() {
		return "The IPN response came back and was a SUCCESS.";
	}
	
}

?>
