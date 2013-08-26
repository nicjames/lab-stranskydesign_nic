<?php

/**
 * Description of WaitingForPaypalResponseState
 *
 * @author nic.stransky
 */
class WaitingForPaypalResponseState implements State {
	private $cart;
	
	public function __construct(Cart $cart) {
		$this->cart = $cart;
	}
	
	public function addItem($item) {
 		out("You have attempted to add an item to your cart, but we are currently waiting for a response from Paypal where you completed your transaction. It is possible that you have not completed the transaction, successful or otherwise, and that possible outcome needs to be handled.");
	}
	
	public function sendToPaypal() {
		out("You tried to Send To Paypal, but this cart has already been sent to Paypal and we're now waiting for a response.");
	}
	
	public function paypalResponseFailure() {
		out("Paypal IPN returned a failure.");
		$this->cart->setState($this->cart->getPaymentFailedState());
	}
	
	public function sendEmailFailureNotice() {
		out("Send Email Failure Notice should never happen, I'm in the Waiting For Paypal Response State.");
	}
	
	public function paypalResponseSuccess() {
		out("Paypal IPN returned a SUCCESS.");
		$this->cart->setState($this->cart->getPaymentSucceededState());
	}
	
	public function sendEmailWithAttachment() {
		out("Send Email With Attachment should never happen, I'm in the Waiting For Paypal Response State.");
	}
	
	public function destroyCart() {
		out("Destroy Cart should never happen. Im in the Waiting For Paypal Response State.");
	}
	
	public function __toString() {
		return "Waiting for Payal's IPN response.";
	}
	
}

?>
